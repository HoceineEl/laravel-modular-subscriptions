# Laravel Modular Subscriptions

A flexible and customizable package for managing subscriptions with modular features in Laravel applications.

## Installation

1. Install the package via Composer:
```bash
composer require hoceineel/laravel-modular-subscriptions
```

2. Publish the configuration file:
```bash
php artisan vendor:publish --provider="HoceineEl\LaravelModularSubscriptions\ModularSubscriptionsServiceProvider" --tag="config"
```
3. Publish the migrations:
```bash
php artisan vendor:publish --provider="HoceineEl\LaravelModularSubscriptions\ModularSubscriptionsServiceProvider" --tag="migrations"
```

4. Run the migrations:
```bash
php artisan migrate
```


## Configuration

After publishing the configuration file, you can find it at `config/modular-subscriptions.php`. Here you can customize the model classes used by the package and define default modules if needed.

```php
return [
    'modules' => [
        // Add your default modules here
    ],
    'models' => [
        'plan' => HoceineEl\LaravelModularSubscriptions\Models\Plan::class,
        'subscription' => HoceineEl\LaravelModularSubscriptions\Models\Subscription::class,
        'module' => HoceineEl\LaravelModularSubscriptions\Models\Module::class,
        'usage' => HoceineEl\LaravelModularSubscriptions\Models\ModuleUsage::class,
    ],
];
```

## Usage

### Creating a Module

Create a new module by extending the `BaseModule` class:

```php
use HoceineEl\LaravelModularSubscriptions\Modules\BaseModule;
use HoceineEl\LaravelModularSubscriptions\Models\Subscription;

class SubscribersModule extends BaseModule
{
    public function getName(): string
    {
        return 'subscribers';
    }

    public function getLabelKey(): string
    {
        return 'Subscribers'; // we will use it like __('Subscribers')
    }

    public function calculateUsage(Subscription $subscription): int
    {
        return $subscription->subscribable->subscribers()->count();
    }

    public function getPricing(Subscription $subscription): float
    {
        $subscriberCount = $this->calculateUsage($subscription);
        return $subscriberCount * 0.5; // $0.50 per subscriber
    }

    public function canUse(Subscription $subscription): bool
    {
        $usage = $this->calculateUsage($subscription);
        $limit = 1000; // Example limit
        return $usage < $limit;
    }
}
```



### Using the Subscribable Trait

Add the `Subscribable` trait to your model:

```php
use HoceineEl\LaravelModularSubscriptions\Traits\Subscribable;

class User extends Model
{
    use Subscribable;
    // ...
}
```

### Managing Subscriptions

Create a new subscription:
```php
$user->newSubscription($planId, $trialDays);
```

Check subscription status:
```php
if ($user->hasSubscription()) {
    // User has an active subscription
}

if ($user->onTrial()) {
    // User is on trial
}

$daysLeft = $user->daysLeft();
```

Cancel a subscription:
```php
$user->cancel();
```

Renew a subscription:
```php
$user->renew(30); // Renew for 30 days
```

Change subscription plan:
```php
$user->changePlan($newPlanId);
```

### Managing Module Usage

Record module usage:
```php
$user->recordUsage('subscribers', 5);
```

Check if a module can be used:
```php
if ($user->canUseModule('subscribers')) {
    // User can use the subscribers module
}
```

## Advanced Usage

### Extending Trial Periods
```php
$user->extendTrial(7); // Extend trial by 7 days
```

### Ending Trial Periods
```php
$user->endTrial();
```

### Calculating Total Usage and Pricing
```php
use HoceineEl\LaravelModularSubscriptions\Facades\ModularSubscriptions;

$subscription = $user->activeSubscription();
$totalUsage = ModularSubscriptions::totalUsage($subscription);
$totalPricing = ModularSubscriptions::totalPricing($subscription);
```


## Extending the Package

You can extend the functionality of this package by:
1. Creating custom modules for specific features
2. Extending the base models (Plan, Subscription, Module, ModuleUsage)

## Testing

Run the tests with:
```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email contact@hoceine.com instead of using the issue tracker.

## Credits

- [Hoceine El Idrissi](https://github.com/hoceineel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---

Made with ❤️ by [Hoceine El Idrissi](https://github.com/hoceineel)
