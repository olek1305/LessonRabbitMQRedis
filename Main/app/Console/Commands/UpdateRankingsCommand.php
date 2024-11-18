<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rankings';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $users = User::where('is_influencer', 1)->get();

        $users->each(function (User $user) {
            $orders = Order::where('user_id', $user->id)->where('complete', 1)->get();
            $revenue = $orders->sum(function (Order $order) {
                return (int) $order->influencer_total;
            });

            Redis::command('zadd', ['rankings', $revenue, $user->full_name]);
        });
    }
}
