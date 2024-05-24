<?php

namespace RealRashid\PlanCraft;

use JsonSerializable;

class Plan implements JsonSerializable
{
    /**
     * The key identifier for the plan.
     *
     * @var string
     */
    public $key;

    /**
     * The name of the plan.
     *
     * @var string
     */
    public $name;

    /**
     * The price of the plan.
     *
     * @var string
     */
    public $price;

    /**
     * The interval of the plan.
     *
     * @var string
     */
    public $interval;

    /**
     * The plan's features.
     *
     * @var array
     */
    public $features;

    /**
     * The plan's eligibilities.
     *
     * @var array
     */
    public $eligibilities;

    /**
     * The plan's unique identifier used for payment processing.
     *
     * @var string|null
     */
    public $planId;

    /**
     * The plan's description.
     *
     * @var string
     */
    public $description;

    /**
     * The number of trial days for the plan.
     *
     * @var int|null
     */
    public $trialDays;

    /**
     * The monthly incentive text.
     *
     * @var string|null
     */
    public $monthlyIncentive;

    /**
     * The yearly incentive text.
     *
     * @var string|null
     */
    public $yearlyIncentive;

    /**
     * Create a new plan instance.
     *
     * @return void
     */
    public function __construct(string $key, string $name, object $price, array $interval, array $features, array $eligibilities, ?array $planId = null)
    {
        $this->key = $key;
        $this->name = $name;
        $this->price = $price;
        $this->interval = $interval;
        $this->features = $features;
        $this->eligibilities = $eligibilities;
        $this->planId = $planId;
    }

    /**
     * Describe the plan.
     *
     * @return $this
     */
    public function description(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Set the trial days for the plan.
     *
     * @return $this
     */
    public function trialDays(?int $trialDays)
    {
        $this->trialDays = $trialDays;

        return $this;
    }

    /**
     * Set the monthly incentive text for the plan.
     *
     * @return $this
     */
    public function monthlyIncentive(?string $incentive)
    {
        $this->monthlyIncentive = $incentive;

        return $this;
    }

    /**
     * Set the yearly incentive text for the plan.
     *
     * @return $this
     */
    public function yearlyIncentive(?string $incentive)
    {
        $this->yearlyIncentive = $incentive;

        return $this;
    }

    /**
     * Get the JSON serializable representation of the object.
     *
     * @return array
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return [
            'key' => $this->key,
            'name' => __($this->name),
            'price' => $this->price,
            'interval' => $this->interval,
            'description' => __($this->description),
            'features' => $this->features,
            'eligibilities' => $this->eligibilities,
            'planId' => $this->planId,
            'trialDays' => $this->trialDays,
            'monthlyIncentive' => $this->monthlyIncentive,
            'yearlyIncentive' => $this->yearlyIncentive,
        ];
    }
}
