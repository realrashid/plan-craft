---
name: plan-craft-development
description: Manage subscriptions and user eligibility using configuration-driven plans, the HasPlan trait, and dynamic feature checking.
---

# Plan Craft Development

## When to use this skill

Use this skill when implementing or modifying subscription-based features, defining user plans, and checking feature access or eligibility in Laravel applications using the `realrashid/plan-craft` package.

## Features

- Publish configuration and migrations (`vendor:publish` tags: `plan-craft-config`, `plan-craft-migrations`).
- Add subscription capabilities to models using the `RealRashid\PlanCraft\Traits\HasPlan` trait.
- Define subscription plans, features, and limits in `config/plan-craft.php`.
- Programmatically subscribe, switch, or check eligibility for plans and features.

## Examples

### Publishing configuration and migrations

```bash
php artisan vendor:publish --provider="RealRashid\PlanCraft\PlanCraftServiceProvider" --tag="plan-craft-config"
php artisan vendor:publish --provider="RealRashid\PlanCraft\PlanCraftServiceProvider" --tag="plan-craft-migrations"
```

### Adding subscription to a User model

```php
use RealRashid\PlanCraft\Traits\HasPlan;

class User extends Authenticatable
{
    use HasPlan;
}
```

### Checking user eligibility in a controller

```php
public function store(Request $request)
{
    if (! auth()->user()->isEligible('create-posts')) {
        return redirect()->back()->with('error', 'Upgrade your plan to create more posts.');
    }
    
    // Logic to create posts...
}
```

### Subscribing to a plan

```php
$user->subscribeTo('premium'); // 'premium' is defined in config/plan-craft.php
```

## Implementation tips for AI agents

- Store plan definitions in `config/plan-craft.php` for centralized, version-controlled plan management.
- Use `hasFeature('feature-name')` for simple boolean access and `isEligible('action-name')` for numeric limits.
- Ensure the `plan_id` and `plan_details` columns are present in your billable model after runningmigrations.
