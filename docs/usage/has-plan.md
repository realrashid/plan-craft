# Checking if User Has a Specific Plan

In this section, we'll explore how to check if a user currently has a specific plan using the `hasPlan` method.

## Usage

The `hasPlan` method queries the database using the `morphOne` relationship to check if the user has an associated plan with the provided `$planKey`. Here's an example of how to use it:

```php
$user = auth()->user();

// Check if the user has the 'pro' plan
$hasProPlan = $user->hasPlan('pro');
```

## Explanation
The code above get the current authenticated user and then checks if they have the specified plan using the hasPlan method. It returns `true` if the user has the plan, and `false` otherwise.

## Result
After running the code, the `$hasProPlan` variable will be `true` if the user has the `'pro'` plan, and `false` if they do not.

<br />

>Note: This method provides a convenient way to verify a user's current plan.
