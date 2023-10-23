# Switching User's Current Plan

In this section, we'll explore how to switch a user's current plan to a different plan identified by either its key or planId using the `switchPlan` method.

## Usage

The `switchPlan` method allows you to change a user's current plan to a new plan identified by either its key or planId. Here's an example of how to use it:

```php
$user = auth()->user();

// Switch the user's current plan to 'pro'
$user->switchPlan('pro'); // Using plan key

// Or, switch the user's current plan using the Stripe or Paddle price ID
$user->switchPlan('monthly_price_id'); // Using Stripe or Paddle price ID
```

## Explanation

The code above get the current authenticated user and then switches their current plan to the specified plan. If the new plan is the same as the current plan, this operation will return `false`.

## Result

After running the code, the user's current plan will be updated to the specified plan.

