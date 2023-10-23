# Deleting User's Current Plan

In this section, we'll explore how to allow a user to delete their current associated plan using the `deletePlan` method.

## Usage

The `deletePlan` method allows the user to delete their current associated plan. Here's an example of how to use it:

```php
$user = auth()->user();

// Attempt to delete the user's current plan
$planDeleted = $user->deletePlan();
```

## Explanation

The code above get the current authenticated user and then attempts to delete their current plan using the `deletePlan()` method. It returns `true` if the plan was deleted successfully, and `false` if no plan is associated with the user.

## Result

After running the code, the `$planDeleted` variable will be `true` if the plan was deleted successfully, and `false` if no plan is associated with the user.

<br />

**Note:** When deleting a plan, it's important to also cancel the associated subscription in the payment gateway (e.g., using Laravel Cashier for Stripe). This ensures that the user won't be billed for the plan in the next billing cycle.

For example, if you're using Stripe, you can cancel the subscription with the following code:

```php
// Step 1: Get the authenticated user
$user = auth()->user();;

// Step 2: Check if the user has an active subscription
if ($user->hasActivePlan()) {

    // Step 3: Cancel the user's Stripe subscription
    $user->subscription('default')->cancelNow();

    // Step 4: Delete the associated PlanCraft plan
    $user->deletePlan();

    // Step 5: Check if the subscription was successfully cancelled
    if ($user->subscription('default')->canceled()) {
        // Step 6: Redirect back with a success message
        return redirect()->back()->with('success','Subscription cancelled successfully.');
    }
}

// Step 7: If any of the steps above failed, redirect back with an error message
return redirect()->back()->with('error','Unable to cancel subscription.');
```
