{{--
  Laravel Boost third-party package AI guideline for realrashid/plan-craft
  Provides concise instructions and examples for AI agents to integrate this package.
--}}

# Plan Craft (realrashid/plan-craft)

Transforming Laravel Plans Management. Break free from conventional database storage constraints by defining subscription plans in a centralized PHP configuration file.

## Features

- **Configuration-Driven Plans**: Define all your subscription plans, features, and eligibility in `config/plan-craft.php`.
- **HasPlan Trait**: Easily manage user subscriptions by adding the `HasPlan` trait to your User (or any billable) model.
- **Dynamic Feature Checking**: Check if a user has access to a feature or is eligible for an action based on their current plan.
- **Serialized Storage**: User plan details are stored as a serialized string in the database, eliminating the need for complex plan/feature tables.

## Publishable tags

- `plan-craft-config` — publishes `config/plan-craft.php`
- `plan-craft-migrations` — publishes the migration to add the `plan_id` and `plan_details` columns to the users table.

Example: `php artisan vendor:publish --provider="RealRashid\PlanCraft\PlanCraftServiceProvider" --tag="plan-craft-config"`

## Typical usage

1. **Add Trait to Model**:
```php
use RealRashid\PlanCraft\Traits\HasPlan;

class User extends Authenticatable
{
    use HasPlan;
}
```

2. **Subscribe a User**:
```php
$user->subscribeTo('premium'); // 'premium' is a key defined in config/plan-craft.php
```

3. **Check Features and Eligibility**:
```php
if ($user->hasFeature('advanced-analytics')) {
    // Show advanced analytics...
}

if ($user->isEligible('create-projects')) {
    // User can create another project...
}
```

4. **Switch Plans**:
```php
$user->switchTo('pro');
```

## Configuration hints

- Define plans under the `plans` key in `config/plan-craft.php`.
- Each plan can have `features` (simple booleans) and `eligibility` (numeric limits).
- Use `plan_id` if you need to map to an external ID (e.g., Stripe/LemonSqueezy Price ID).

## Notes for Laravel 13

- Fully compatible with Laravel 13 and PHP 8.2+.
- Ensure the `plan_id` and `plan_details` columns are present in your billable model's table.
