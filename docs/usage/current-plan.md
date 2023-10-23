# Getting User's Current Plan

In this section, we'll explore how to retrieve the user's current plan using the `currentPlan()` method.

## Usage

The `currentPlan()` method allows you to get the details of the user's current plan. Here's an example of how to use it:

```php
$user = auth()->user();

// Get the user's current plan
$currentPlan = $user->currentPlan();
```

## Output

```json
{
  "key": "basic",
  "name": "Basic",
  "price": {
    "monthly": "12",
    "yearly": "129.6"
  },
  "interval": [
    "Monthly",
    "Yearly"
  ],
  "description": "Basic plan users can create 10 Chirps on per team and Create 5 Teams.",
  "features": [
    "10 Chirps",
    "5 Teams"
  ],
  "eligibilities": {
    "max_chirps": 2,
    "max_teams": 5
  },
  "planId": {
    "monthly": "bisic_price_monthly",
    "yearly": "bisic_price_yearly"
  },
  "trialDays": 7,
  "monthlyIncentive": null,
  "yearlyIncentive": "Save 10%"
}
```

## Explanation

The code above get the current authenticated user and then retrieves their current plan using the `currentPlan()` method.

## Result
After running the code, the `$currentPlan` variable will contain the user's current plan, or `null` if no plan is associated with the user.

Note: If the user has an associated plan, the method uses the 'key' attribute of the plan to fetch the complete plan details using the `PlanCraft::findPlan()` method.
