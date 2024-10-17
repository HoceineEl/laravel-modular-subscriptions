<?php

return [
    'modules' => [
        // List all available module classes here
        App\Modules\SubscribersModule::class,
        // Add other modules...
    ],
    'models' => [
        'plan' => HoceineEl\LaravelModularSubscriptions\Models\Plan::class,
        'subscription' => HoceineEl\LaravelModularSubscriptions\Models\Subscription::class,
        'module' => HoceineEl\LaravelModularSubscriptions\Models\Module::class,
        'usage' => HoceineEl\LaravelModularSubscriptions\Models\ModuleUsage::class,
    ],
];
