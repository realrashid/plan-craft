# Checking if User Has an Active Plan

In this section, we'll explore how to check if a user currently has an active plan using the `hasActivePlan` method.

## Usage

The `hasActivePlan` method checks if there is an associated plan for the user using the `morphOne` relationship. Here's an example of how to use it:

```php
$user = auth()->user();

// Check if the user has an active plan
$hasActivePlan = $user->hasActivePlan();
```

## Explanation
The code above get the current authenticated user and then checks if they have an active plan using the hasActivePlan method. It returns `true` if a plan exists, indicating an active plan, and `false` if no plan is found.

Result
After running the code, the `$hasActivePlan` variable will be `true` if the user has an active plan, and `false` if they do not.

<br />

>Note: This method is useful for determining if a user is currently subscribed to any plan.
