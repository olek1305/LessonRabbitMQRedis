<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = DB::connection('old_mysql')->table('users')->get();

        foreach ($users as $user) {
             User::create([
                 'id' => $user->id,
                 'first_name' => $user->first_name,
                 'last_name' => $user->last_name,
                 'email' => $user->email,
                 'email_verified_at' => $user->email_verified_at,
                 'password' => $user->password,
                 'remember_token' => $user->remember_token,
                 'created_at' => $user->created_at,
                 'updated_at' => $user->updated_at,
                 'is_influencer' => $user->is_influencer,
             ]);
        }
    }
}
