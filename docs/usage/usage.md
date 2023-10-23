# Integrating Plans with Billable

After successfully installing the PlanCraft package, you can start associating plans with your billable models, such as `User` or `Team`. To do this, follow these steps:

## 1. Use the `HasPlan` Trait

In the model file (`User.php`, `Team.php`, or any other applicable model), use the `HasPlan` trait. This trait provides the necessary methods for managing plans associated with the model.

```php
use Illuminate\Database\Eloquent\Model;
use PlanCraft\Trait\HasPlan;

class User extends Model
{
    use HasPlan;
}
```

## 2. Managing Plans

With the `HasPlan` trait, you gain access to a set of methods for managing plans associated with your billable models. Here's a brief overview of the available methods:

`plan()`: Retrieve the user's associated plan. This method defines a morphOne relationship with the PlanModel class.

`hasPlan($planKey)`: Check if the user currently has a specific plan.

`hasActivePlan()`: Check if the user currently has an active plan.

`findPlan($planKeyOrId)`: Find a plan based on a Plan Key or planId.

`createPlan($planKeyOrId)`: Create a new plan for the user.

`currentPlan()`: Get the details of the user's current plan.

`deletePlan()`: Delete the user's current plan.

`getPlanFeatures()`: Get features of the user's current plan.

`canAccessFeature($feature)`: Check if the user can access a specific feature.

`checkEligibility($eligibilityKey, $userCreated)`: Check if the user is eligible to perform a specific action based on their subscription plan.

`switchPlan($newPlanKeyOrId)`: Switch the user's current plan to a different plan identified by key or planId.

These methods empower you to seamlessly manage plans for your billable models. Customize and leverage them to suit your specific use cases.
