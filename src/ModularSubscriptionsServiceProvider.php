<?php

namespace HoceineEl\LaravelModularSubscriptions;

use Illuminate\Support\ServiceProvider;

class ModularSubscriptionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config/modular-subscriptions.php', 'modular-subscriptions');

        $this->publishes([
            __DIR__ . '/../config/modular-subscriptions.php' => $this->app->configPath('modular-subscriptions.php'),
        ], 'config');
    }

    public function register()
    {
        $this->app->singleton('modular-subscriptions', function ($app) {
            return new ModularSubscriptionManager();
        });
    }
}
