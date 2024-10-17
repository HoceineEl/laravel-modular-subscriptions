<?php

namespace HoceineEl\LaravelModularSubscriptions;

use Illuminate\Support\ServiceProvider;

class ModularSubscriptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/modular-subscriptions.php' => config_path('modular-subscriptions.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__ . '/../config/modular-subscriptions.php', 'modular-subscriptions');
    }

    public function register()
    {
        $this->app->singleton('modular-subscriptions', function ($app) {
            return new ModularSubscriptionManager();
        });
    }
}
