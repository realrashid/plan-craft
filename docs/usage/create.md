# Creating User Plan

In this section, we'll cover how to create a plan for a user using the `createPlan` method.

## Usage

The `createPlan` method allows you to associate a specific plan with a user. You can pass either the plan key or the Stripe or Paddle price ID. Here's an example of how to use it:

```php
$user = auth()->user();

// Create the 'basic' plan for the user
$user->createPlan('basic'); // Using plan key

// Or, create the 'basic' plan for the user with a yearly interval
$user->createPlan('yearly_price_id'); // Using Stripe or Paddle price ID

```

## Explanation

The code above get the current authenticated user and then associates the 'basic' plan with them. If the user already has an existing plan, this operation will return `false`.

## Result

After running the code, the user will now be associated with the specified plan.
