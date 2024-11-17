<?php

namespace App\Providers;

use App\Events\OrderCompletedEvent;
use App\Events\ProductUpdateEvent;
use App\Listeners\ProductCacheFlush;
use App\Listeners\UpdateRankingsListener;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Event;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Gate::define('view', function(User $user, $model) {
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });

        Gate::define('edit', function(User $user, $model) {
            return $user->hasAccess("edit_{$model}");
        });

        Passport::tokensCan([
            'admin' => 'Administrator Scope',
            'influencer' => 'Influencer Scope',
        ]);

        Event::listen(
            OrderCompletedEvent::class,
            UpdateRankingsListener::class
        );

        Event::listen(
            ProductUpdateEvent::class,
            ProductCacheFlush::class
        );
    }
}
