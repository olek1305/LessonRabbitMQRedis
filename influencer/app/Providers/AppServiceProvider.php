<?php

namespace App\Providers;

use App\Events\AdminAddedEvent;
use App\Events\OrderCompletedEvent;
use App\Events\ProductUpdateEvent;
use App\Listeners\NotifyAddedAdminListener;
use App\Listeners\NotifyAdminListener;
use App\Listeners\NotifyInfluencerListener;
use App\Listeners\ProductCacheFlush;
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
            [NotifyAdminListener::class, NotifyInfluencerListener::class],
        );

        Event::listen(
            AdminAddedEvent::class,
            NotifyAddedAdminListener::class
        );

        Event::listen(
            ProductUpdateEvent::class,
            ProductCacheFlush::class
        );
    }
}
