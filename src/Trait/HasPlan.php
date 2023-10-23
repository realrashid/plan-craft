<?php

namespace RealRashid\PlanCraft\Trait;

use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use RealRashid\PlanCraft\Models\Plan as PlanModel;
use RealRashid\PlanCraft\Plan;
use RealRashid\PlanCraft\PlanCraft;

trait HasPlan
{
    /**
     * Retrieve the user's associated plan.
     *
     * This method defines a morphOne relationship with the PlanModel class, allowing the user
     * to have a single associated plan. It returns an instance of the MorphOne relationship,
     * which can be used to perform database queries related to the user's plan.
     *
     * @return Illuminate\Database\Eloquent\Relations\MorphOne - The morphOne relationship instance.
     */
    public function plan(): MorphOne
    {
        return $this->morphOne(PlanModel::class, 'planable');
    }

    /**
     * Check if the user currently has a specific plan.
     *
     * This method queries the database using the morphOne relationship to check if the user has
     * an associated plan with the provided $planKey. If a plan with the specified key is found,
     * the method returns true, indicating that the user has the plan. Otherwise, it returns false.
     *
     * @param  string  $planKey - The key of the plan to check for.
     * @return bool - True if the user has the plan, false otherwise.
     */
    public function hasPlan(string $planKey): bool
    {
        return $this->plan()->where('key', $planKey)->exists();
    }

    /**
     * Check if the user currently has an active plan.
     *
     * This method checks if there is an associated plan for the user using the morphOne
     * relationship. If a plan exists, it is considered active, and the method returns true.
     * Otherwise, if no plan is found, it is considered inactive, and the method returns false.
     *
     * @return bool - True if the user has an active plan, false otherwise.
     */
    public function hasActivePlan(): bool
    {
        return $this->plan()->exists();
    }

    /**
     * Find a plan based on a Plan Key or planId.
     *
     * This method serves as a bridge to the `findPlan` method in the `PlanCraft` class. It takes
     * a key or planId as input and attempts to locate a plan using the static `findPlan` method.
     * If a plan is found, it is returned as a `Plan` instance. If no plan matches the provided key
     * or planId, the method returns null.
     *
     * @param  string  $planKey - The key or planId of the plan to find.
     * @return RealRashid\PlanCraft\Plan|null - The corresponding Plan instance, or null if not found.
     */
    public function findPlan($planKey): ?Plan
    {
        return PlanCraft::findPlan($planKey);
    }

    /**
     * Create a new plan for the user.
     *
     * This method attempts to create a new plan for the user. It first checks if the user
     * already has an existing plan associated with them. If a plan exists, the method returns
     * false, indicating that a new plan cannot be created. If no plan is associated with the
     * user, the method proceeds to find a plan based on the provided key or planId. If a valid
     * plan is found, a new plan record is created using the morphOne relationship, associating
     * it with the user. The method returns true to indicate a successful plan creation.
     *
     * @param  string  $planKeyOrId - The key or planId of the plan to create.
     * @return bool - True if the plan was created successfully, false otherwise.
     */
    public function createPlan($planKeyOrId): bool
    {
        // Check if the user already has a plan
        if ($this->plan()->exists()) {
            return false; // User already has a plan, cannot create a new one
        }

        // Find the plan based on key or planId
        $plan = $this->findPlan($planKeyOrId);

        // Check if a valid plan was found
        if (! $plan) {
            return false; // Plan with the provided key or planId was not found
        }

        // Create a new plan using the morphOne relationship
        $this->plan()->create(['key' => $plan->key]);

        // Return true to indicate successful creation
        return true;
    }

    /**
     * Get the details of the user's current plan.
     *
     * This method retrieves the current plan associated with the user. If a plan is found,
     * it uses the 'key' attribute of the plan to fetch the complete plan details using the
     * PlanCraft::findPlan() method.
     *
     * @return RealRashid\PlanCraft\Plan|null - The user's current plan, or null if no plan is found.
     */
    public function currentPlan(): ?Plan
    {
        // Retrieve the current plan associated with the user
        $plan = $this->plan;

        return $plan ? $this->findPlan($plan->key) : null;
    }

    /**
     * Delete the user's current plan.
     *
     * This method allows the user to delete their current associated plan. It first checks if
     * a plan is currently associated with the user. If a plan is found, it is deleted using
     * the `delete` method of the plan model, and the method returns true to indicate
     * successful deletion. If no plan is associated with the user, it returns false.
     *
     * @return bool - True if the plan was deleted successfully, false if no plan is associated.
     */
    public function deletePlan(): bool
    {
        // Retrieve the current plan associated with the user
        $currentPlan = $this->plan;

        // Check if a plan was found
        if ($currentPlan) {
            // Delete the current plan
            $currentPlan->delete();

            // Return true to indicate successful deletion
            return true;
        }

        // Return false if no plan is associated with the user
        return false;
    }

    /**
     * Get features of the user's current plan.
     *
     * This method retrieves the features associated with the user's current plan, if one exists.
     * It first checks if there is a current plan associated with the user. If a plan is found,
     * it uses the `findPlan` method to retrieve the plan details, including its features.
     * The method then returns an array of features. If no plan is associated, it returns null.
     *
     * @return array|null - An array of features or null if no plan is associated.
     */
    public function getPlanFeatures(): ?array
    {
        $plan = $this->plan;

        return $plan ? $this->findPlan($plan->key)->features : null;
    }

    /**
     * Check if the user can access a specific feature.
     *
     * This method verifies whether the user has an active plan and if the specific feature
     * is accessible based on the plan's defined features. It returns a boolean value indicating
     * if the user can access the feature.
     *
     * @param  string  $feature - The name of the feature to check access for.
     * @return bool - True if the user can access the feature, false otherwise.
     */
    public function canAccessFeature(string $feature): bool
    {
        return $this->plan && $this->checkSpecificFeatureAccess($feature);
    }

    /**
     * Check if the user is eligible to perform a specific action based on their subscription plan.
     *
     * This method determines if the user is eligible to perform a specific action based on their
     * subscription plan's configured eligibility limits. It takes an eligibility key and the count
     * of times the user has already performed the action. It returns a boolean value indicating
     * whether the user is eligible.
     *
     * @param  string  $eligibilityKey - The key of the eligibility to check eligibility for.
     * @param  int  $userCreated - The user's count for the specific eligibility limit (default is 0).
     * @return bool - True if the user is eligible, false otherwise.
     */
    public function checkEligibility(string $eligibilityKey, int $userCreated = 0): bool
    {
        // Check if user has a valid plan
        $plan = $this->plan;
        if (! $plan) {
            return false; // User has no active plan, cannot perform the action
        }

        // Retrieve the plan configuration
        $planConfig = $this->findPlan($plan->key);

        if (! $planConfig) {
            return false; // Plan configuration not found, cannot determine eligibility
        }

        // Get the eligibility limit for the specified eligibilityKey
        $limit = $planConfig->eligibilities[$eligibilityKey] ?? null;

        if ($limit === null) {
            return false; // Eligibility limit not found, cannot determine eligibility
        }

        // Check if the limit is set to 0 (unlimited access)
        if ($limit === 0) {
            return true;
        }

        // Check if the user has reached the limit
        return $userCreated < $limit;
    }

    /**
     * Switch the user's current plan to a different plan identified by key or planId.
     *
     * This method allows the user to change their current plan to a new plan identified by either its key or planId.
     * It first checks if the new plan is different from the current plan. If they are the same, it
     * returns false to indicate that no switch was performed. If the new plan is found, it deletes
     * the current plan (if it exists) and creates a new plan with the specified key.
     *
     * @param  string  $newPlanKeyOrId - The key or planId of the new plan.
     * @return bool - True if the switch was successful, false otherwise.
     */
    public function switchPlan(string $newPlanKeyOrId): bool
    {
        $currentPlan = $this->plan;

        if ($currentPlan && ($currentPlan->key === $newPlanKeyOrId || $currentPlan->planId === $newPlanKeyOrId)) {
            return false; // New plan is the same as the current plan
        }

        $newPlan = $this->findPlan($newPlanKeyOrId);

        if (! $newPlan) {
            return false; // New plan not found
        }

        if ($currentPlan) {
            $currentPlan->delete();
        }

        $newPlan = new PlanModel(['key' => $newPlan->key]);
        $this->plan()->save($newPlan);

        return true;
    }

    /**
     * Check if the user has access to a specific feature.
     *
     * This method determines if the user has access to a specific feature based on their current plan.
     * It first retrieves the features associated with the user's plan. It then checks if the desired
     * feature is included in the list of plan features, or if there's a wildcard (*) that grants access
     * to all features. Additionally, it checks for specific wildcard cases with the help of the
     * `checkWildcardFeature` method.
     *
     * @param  string  $feature - The specific feature to check for access.
     * @return bool - True if the user has access, false otherwise.
     */
    protected function checkSpecificFeatureAccess(string $feature): bool
    {
        $features = $this->getPlanFeatures();

        return in_array($feature, $features) ||
            in_array('*', $features) ||
            $this->checkWildcardFeature($feature, $features);
    }

    /**
     * Check if a specific feature with wildcard is accessible.
     *
     * This method determines if a specific feature with a wildcard (*) is accessible for the user's current plan.
     * It checks if the feature ends with ':create' or ':update' and if there's a wildcard entry in the list of plan features
     * that grants access to all create or update actions. This method is used in conjunction with `checkSpecificFeatureAccess`.
     *
     * @param  string  $feature - The specific feature to check for wildcard access.
     * @param  array  $features - The list of features associated with the user's plan.
     * @return bool - True if the user has wildcard access to the feature, false otherwise.
     */
    protected function checkWildcardFeature(string $feature, array $features): bool
    {
        return (Str::endsWith($feature, ':create') && in_array('*:create', $features)) ||
            (Str::endsWith($feature, ':update') && in_array('*:update', $features));
    }
}
