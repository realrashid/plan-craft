<?php

namespace RealRashid\PlanCraft;

class PlanCraft
{
    /**
     * The plans that are available to assign to users.
     *
     * @var array
     */
    public static $plans = [];

    /**
     * The features that exist within the application.
     *
     * @var array
     */
    public static $features = [];

    /**
     * Find the plan with the given key or planId.
     *
     * @param  string  $key  - The key or planId of the plan to find.
     * @return RealRashid\PlanCraft\Plan|null - The found plan or null if not found.
     */
    public static function findPlan(string $key): ?Plan
    {
        foreach (static::$plans as $plan) {
            if ($plan->key === $key || (is_array($plan->planId) && in_array($key, $plan->planId))) {
                return $plan;
            }
        }

        return null;
    }

    /**
     * Define a plan.
     *
     * @param  string  $key  - The key of the plan.
     * @param  string  $name  - The name of the plan.
     * @param  string  $price  - The price of the plan (formatted as "monthly|yearly").
     * @param  string  $interval  - The billing interval of the plan (formatted as "Monthly|Yearly").
     * @param  array  $features  - Array of features associated with the plan.
     * @param  array  $eligibilities  - Array of eligibility criteria for the plan.
     * @param  string  $planId  - The plan's unique identifier used for payment processing (formatted as "price_monthly|price_yearly").
     * @return RealRashid\PlanCraft\Plan - The newly created plan.
     */
    public static function create(string $key, string $name, string $price, string $interval, array $features, array $eligibilities, ?string $planId = null)
    {
        // Ensure unique features across all plans
        static::$features = collect(array_merge(static::$features, $features))
            ->unique()
            ->sort()
            ->values()
            ->all();

        // Split the price and planId strings into arrays
        $priceArray = array_combine(explode('|', strtolower($interval)), explode('|', $price));
        $planIdArray = $planId ? array_combine(explode('|', strtolower($interval)), explode('|', $planId)) : null;

        // Create a Price object to hold the prices
        $priceObject = (object) $priceArray;

        // Create a new Plan instance with the Price object and store it
        return tap(new Plan($key, $name, $priceObject, explode('|', $interval), $features, $eligibilities, $planIdArray), function ($plan) use ($key) {
            static::$plans[$key] = $plan;
        });
    }

    /**
     * Get all defined plans with converted descriptions.
     *
     * @return array - Array of plans with descriptions.
     */
    public static function plans(): array
    {
        return collect(static::$plans)->transform(function ($plan) {
            return with($plan->jsonSerialize(), function ($data) {
                return (new Plan(
                    $data['key'],
                    $data['name'],
                    $data['price'],
                    $data['interval'],
                    $data['features'],
                    $data['eligibilities'],
                    $data['planId'],
                ))->description($data['description'])->trialDays($data['trialDays'])
                    ->monthlyIncentive($data['monthlyIncentive'])
                    ->yearlyIncentive($data['yearlyIncentive']);
            });
        })->values()->all();
    }

    /**
     * Check if there are any plans defined.
     *
     * @return bool - True if there are plans, false otherwise.
     */
    public static function hasPlans(): bool
    {
        return count(static::$plans) > 0;
    }

    /**
     * Check if there are any features defined.
     *
     * @return bool - True if there are features, false otherwise.
     */
    public static function hasFeatuers(): bool
    {
        return count(static::$features) > 0;
    }
}
