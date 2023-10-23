<?php

use RealRashid\PlanCraft\Plan;
use RealRashid\PlanCraft\PlanCraft;

it('can create a plan', function () {
    // Create a basic plan and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])->description('Basic plan description.');

    // Assert that the plans array has one item
    expect(PlanCraft::$plans)->toHaveCount(1);

    // Assert that the features array has two items
    expect(PlanCraft::$features)->toHaveCount(2);

    // Assert that the 'basic' plan exists and is an object
    expect(PlanCraft::findPlan('basic'))->toBeObject();
});

it('can find a non-existent plan', function () {
    // Try to find a plan that doesn't exist
    $plan = PlanCraft::findPlan('non_existent');

    // Assert that the result is null
    expect($plan)->toBeNull();
});

it('can create a plan with planId', function () {
    // Create a basic plan with a plan ID and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5], 'stripe_basic_plan_id')->description('Basic plan description.');

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the plan ID is set correctly
    expect($plan->planId['monthly'])->toBe('stripe_basic_plan_id');
});

it('includes planId when serializing', function () {
    // Create a basic plan with a plan ID and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5], 'stripe_basic_plan_id')->description('Basic plan description.');

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Serialize the plan
    $serializedPlan = json_encode($plan, JSON_PRETTY_PRINT);

    // Assert that the serialized plan includes the plan ID
    expect($serializedPlan)->toContain('stripe_basic_plan_id');
});

it('can get all plans', function () {
    // Create a basic plan and a pro plan with descriptions
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])->description('Basic plan description.');
    PlanCraft::create('pro', 'Pro Plan', '$20', 'monthly', ['feature3', 'feature4'], ['max_limit' => 10])->description('Pro plan description.');

    // Retrieve all plans
    $plans = PlanCraft::plans();

    // Assert that there are two plans and they are instances of the Plan class
    expect($plans)->toHaveCount(2);
    expect($plans[0])->toBeInstanceOf(Plan::class);
    expect($plans[1])->toBeInstanceOf(Plan::class);
});

it('can check if there are plans', function () {
    // Check if there are plans (should initially be false)
    $hasPlans = PlanCraft::hasPlans();

    // Assert that there are no plans initially
    expect($hasPlans)->toBeFalse();

    // Create a basic plan
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])->description('Basic plan description.');

    // Check if there are plans again (should now be true)
    $hasPlans = PlanCraft::hasPlans();

    // Assert that there is now at least one plan
    expect($hasPlans)->toBeTrue();
});

it('can check if there are features', function () {
    // Check if there are features (should initially be false)
    $hasFeatures = PlanCraft::hasFeatuers();

    // Assert that there are no features initially
    expect($hasFeatures)->toBeFalse();

    // Create a basic plan
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])->description('Basic plan description.');

    // Check if there are features again (should now be true)
    $hasFeatures = PlanCraft::hasFeatuers();

    // Assert that there is now at least one feature
    expect($hasFeatures)->toBeTrue();
});

it('can create a plan with empty features and eligibilities', function () {
    // Create a plan without features and eligibilities
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', [], []);

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the plan exists
    expect($plan)->not->toBeNull();

    // Assert that the plan features and eligibilities are empty
    expect($plan->features)->toBe([]);
    expect($plan->eligibilities)->toBe([]);
});

it('can find all plans with descriptions', function () {
    // Create plans with descriptions
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])->description('Basic plan description.');
    PlanCraft::create('pro', 'Pro Plan', '$20', 'monthly', ['feature3', 'feature4'], ['max_limit' => 10])->description('Pro plan description.');

    // Retrieve all plans with descriptions
    $plans = PlanCraft::plans();

    // Assert that there are two plans with descriptions
    expect($plans)->toHaveCount(2);
    expect($plans[0]->description)->toBe('Basic plan description.');
    expect($plans[1]->description)->toBe('Pro plan description.');
});

it('can create a plan without a planId', function () {
    // Create a plan without a planId
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5]);

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the plan ID is null
    expect($plan->planId)->toBeNull();
});

it('can check if there are no plans initially', function () {
    // Check if there are plans (should initially be false)
    $hasPlans = PlanCraft::hasPlans();

    // Assert that there are no plans initially
    expect($hasPlans)->toBeFalse();
});

it('can check if there are no features initially', function () {
    // Check if there are features (should initially be false)
    $hasFeatures = PlanCraft::hasFeatuers();

    // Assert that there are no features initially
    expect($hasFeatures)->toBeFalse();
});

it('can find all plans when no plans exist', function () {
    // Retrieve all plans when no plans exist
    $plans = PlanCraft::plans();

    // Assert that there are no plans
    expect($plans)->toBeEmpty();
});

it('can create a plan with a description and planId', function () {
    // Create a plan with a description and planId
    PlanCraft::create('premium', 'Premium Plan', '$15', 'monthly', ['feature5'], ['max_limit' => 20], 'stripe_premium_plan_id')
        ->description('Premium plan description.');

    // Retrieve the plan
    $plan = PlanCraft::findPlan('premium');

    // Assert that the plan description is set
    expect($plan->description)->toBe('Premium plan description.');

    // Assert that the plan ID is set correctly
    expect($plan->planId)->toBe(['monthly' => 'stripe_premium_plan_id']);
});

it('can update an existing plan description', function () {
    // Create a plan with an initial description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1'], ['max_limit' => 5])
        ->description('Initial description.');

    // Update the plan's description
    PlanCraft::findPlan('basic')->description('Updated description.');

    // Retrieve the updated plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the plan's description is updated
    expect($plan->description)->toBe('Updated description.');
});

it('can create multiple plans with different planIds', function () {
    // Create plans with different planIds
    PlanCraft::create('standard', 'Standard Plan', '$12', 'monthly', ['feature6'], ['max_limit' => 15], 'stripe_standard_plan_id')
        ->description('Standard plan description.');

    PlanCraft::create('business', 'Business Plan', '$25', 'monthly', ['feature7'], ['max_limit' => 30], 'stripe_business_plan_id')
        ->description('Business plan description.');

    // Retrieve the plans
    $standardPlan = PlanCraft::findPlan('standard');
    $businessPlan = PlanCraft::findPlan('business');

    // Assert that the planIds are set correctly
    expect($standardPlan->planId)->toBe(['monthly' => 'stripe_standard_plan_id']);
    expect($businessPlan->planId)->toBe(['monthly' => 'stripe_business_plan_id']);
});

it('can check if there are plans after creating them', function () {
    // Check if there are plans (should initially be false)
    $hasPlans = PlanCraft::hasPlans();

    // Assert that there are no plans initially
    expect($hasPlans)->toBeFalse();

    // Create a new plan
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1'], ['max_limit' => 5]);

    // Check if there are plans again (should now be true)
    $hasPlans = PlanCraft::hasPlans();

    // Assert that there is now at least one plan
    expect($hasPlans)->toBeTrue();
});

it('can check if there are features after creating a plan', function () {
    // Check if there are features (should initially be false)
    $hasFeatures = PlanCraft::hasFeatuers();

    // Assert that there are no features initially
    expect($hasFeatures)->toBeFalse();

    // Create a new plan with a feature
    PlanCraft::create('premium', 'Premium Plan', '$15', 'monthly', ['feature5'], ['max_limit' => 20]);

    // Check if there are features again (should now be true)
    $hasFeatures = PlanCraft::hasFeatuers();

    // Assert that there is now at least one feature
    expect($hasFeatures)->toBeTrue();
});

it('can find a plan by key', function () {
    // Create a plan with the key 'pro'
    $planKey = 'pro';
    $plan = PlanCraft::create($planKey, 'Pro Plan', '99', 'monthly', [], []);

    // Find a plan using the key 'pro'
    $foundPlan = PlanCraft::findPlan($planKey);

    // Assert Ensure that the found plan matches the one we created
    expect($foundPlan)->toBe($plan);
});

it('can find a plan by planId', function () {
    // Create a plan with the key 'pro' and planId 'price_1NqHCtKiNV0qopCO5HCZVeAC'
    $planKey = 'pro';
    $planId = 'price_1NqHCtKiNV0qopCO5HCZVeAC';
    $plan = PlanCraft::create($planKey, 'Pro Plan', '99|1188', 'monthly|yearly', [], [], 'price_monthly|price_yearly');

    // dd($plan);
    // Find a plan using the planId 'price_1NqHCtKiNV0qopCO5HCZVeAC'
    $foundPlan = PlanCraft::findPlan('price_monthly');

    // Assert Ensure that the found plan matches the one we created
    expect($foundPlan)->toBe($plan);
});

it('can create a plan with trial days', function () {
    // Create a basic plan with trial days and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])
        ->description('Basic plan description.')
        ->trialDays(7);

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the trial days are set correctly
    expect($plan->trialDays)->toBe(7);
});

it('can serialize a plan with trial days', function () {
    // Create a basic plan with trial days and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])
        ->description('Basic plan description.')
        ->trialDays(7);

    // Retrieve the plan
    $plan = PlanCraft::findPlan('basic');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the serialized plan includes the trial days
    expect($json)->toContain('"trialDays":7');
});

it('can update trial days', function () {
    // Create a basic plan with trial days and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])
        ->description('Basic plan description.')
        ->trialDays(7);

    // Update the trial days
    PlanCraft::findPlan('basic')->trialDays(14);

    // Retrieve the updated plan
    $plan = PlanCraft::findPlan('basic');

    // Assert that the trial days are updated
    expect($plan->trialDays)->toBe(14);
});

it('can serialize a plan with updated trial days', function () {
    // Create a basic plan with trial days and set its description
    PlanCraft::create('basic', 'Basic Plan', '$10', 'monthly', ['feature1', 'feature2'], ['max_limit' => 5])
        ->description('Basic plan description.')
        ->trialDays(7);

    // Update the trial days
    PlanCraft::findPlan('basic')->trialDays(14);

    // Retrieve the updated plan
    $plan = PlanCraft::findPlan('basic');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the serialized plan includes the updated trial days
    expect($json)->toContain('"trialDays":14');
});

it('can set and retrieve monthly incentive text', function () {
    // Create a new plan instance
    $plan = PlanCraft::create('pro', 'Pro Plan', '$19', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set monthly incentive
    $plan->monthlyIncentive('Save 10%');

    // Retrieve the monthly incentive text
    $monthlyIncentive = $plan->monthlyIncentive;

    // Assert that the monthly incentive text is set correctly
    expect($monthlyIncentive)->toBe('Save 10%');
});

it('can set and retrieve yearly incentive text', function () {
    // Create a new plan instance
    $plan = PlanCraft::create('pro', 'Pro Plan', '$228', 'yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set yearly incentive
    $plan->yearlyIncentive('Save 15%');

    // Retrieve the yearly incentive text
    $yearlyIncentive = $plan->yearlyIncentive;

    // Assert that the yearly incentive text is set correctly
    expect($yearlyIncentive)->toBe('Save 15%');
});

it('can serialize a plan with monthly incentive', function () {
    // Create a new plan instance with monthly incentive
    $plan = PlanCraft::create('pro', 'Pro Plan', '$19', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set monthly incentive
    $plan->monthlyIncentive('Save 10%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the monthly incentive property
    expect($json)->toContain('"monthlyIncentive":"Save 10%"');
});

it('can serialize a plan with yearly incentive', function () {
    // Create a new plan instance with yearly incentive
    $plan = PlanCraft::create('pro', 'Pro Plan', '$228', 'yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set yearly incentive
    $plan->yearlyIncentive('Save 15%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the yearly incentive property
    expect($json)->toContain('"yearlyIncentive":"Save 15%"');
});

it('can create a plan with both monthly and yearly incentives', function () {
    // Create a new plan instance with both monthly and yearly prices
    $plan = PlanCraft::create('pro', 'Pro Plan', '$19|$228', 'Monthly|Yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set both monthly and yearly incentives
    $plan->monthlyIncentive('Save 10%');
    $plan->yearlyIncentive('Save 15%');

    // Retrieve the monthly and yearly incentives
    $monthlyIncentive = $plan->monthlyIncentive;
    $yearlyIncentive = $plan->yearlyIncentive;

    // Assert that both incentives are set correctly
    expect($monthlyIncentive)->toBe('Save 10%');
    expect($yearlyIncentive)->toBe('Save 15%');
});

it('can serialize a plan with both monthly and yearly incentives', function () {
    // Create a new plan instance with both monthly and yearly prices
    $plan = PlanCraft::create('pro', 'Pro Plan', '$19|$228', 'Monthly|Yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set both monthly and yearly incentives
    $plan->monthlyIncentive('Save 10%');
    $plan->yearlyIncentive('Save 15%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains both monthly and yearly incentive properties
    expect($json)->toContain('"monthlyIncentive":"Save 10%"');
    expect($json)->toContain('"yearlyIncentive":"Save 15%"');
});

it('can set and retrieve monthly incentive text with multiple plans', function () {
    // Create a new plan instance
    $plan1 = PlanCraft::create('pro1', 'Pro Plan 1', '$19', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);
    $plan2 = PlanCraft::create('pro2', 'Pro Plan 2', '$20', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set monthly incentive
    $plan1->monthlyIncentive('Save 10%');
    $plan2->monthlyIncentive('Save 15%');

    // Retrieve the monthly incentive text
    $monthlyIncentive1 = $plan1->monthlyIncentive;
    $monthlyIncentive2 = $plan2->monthlyIncentive;

    // Assert that the monthly incentive text is set correctly
    expect($monthlyIncentive1)->toBe('Save 10%');
    expect($monthlyIncentive2)->toBe('Save 15%');
});

it('can set and retrieve yearly incentive text with multiple plans', function () {
    // Create a new plan instance
    $plan1 = PlanCraft::create('pro1', 'Pro Plan 1', '$228', 'yearly', ['20 Chirps'], ['max_chirps' => 20]);
    $plan2 = PlanCraft::create('pro2', 'Pro Plan 2', '$230', 'yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set yearly incentive
    $plan1->yearlyIncentive('Save 10%');
    $plan2->yearlyIncentive('Save 15%');

    // Retrieve the yearly incentive text
    $yearlyIncentive1 = $plan1->yearlyIncentive;
    $yearlyIncentive2 = $plan2->yearlyIncentive;

    // Assert that the yearly incentive text is set correctly
    expect($yearlyIncentive1)->toBe('Save 10%');
    expect($yearlyIncentive2)->toBe('Save 15%');
});

it('can serialize a plan with monthly and yearly incentives with multiple plans', function () {
    // Create a new plan instance with both monthly and yearly prices
    $plan1 = PlanCraft::create('pro1', 'Pro Plan 1', '$19|$228', 'Monthly|Yearly', ['20 Chirps'], ['max_chirps' => 20]);
    $plan2 = PlanCraft::create('pro2', 'Pro Plan 2', '$20|$230', 'Monthly|Yearly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set both monthly and yearly incentives
    $plan1->monthlyIncentive('Save 10%');
    $plan1->yearlyIncentive('Save 15%');
    $plan2->monthlyIncentive('Save 20%');
    $plan2->yearlyIncentive('Save 25%');

    // Serialize the plans
    $json1 = json_encode($plan1);
    $json2 = json_encode($plan2);

    // Assert that the JSON contains both monthly and yearly incentive properties
    expect($json1)->toContain('"monthlyIncentive":"Save 10%"');
    expect($json1)->toContain('"yearlyIncentive":"Save 15%"');
    expect($json2)->toContain('"monthlyIncentive":"Save 20%"');
    expect($json2)->toContain('"yearlyIncentive":"Save 25%"');
});

it('can set and retrieve trial days with multiple plans', function () {
    // Create a new plan instance
    $plan1 = PlanCraft::create('pro1', 'Pro Plan 1', '$19', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);
    $plan2 = PlanCraft::create('pro2', 'Pro Plan 2', '$20', 'monthly', ['20 Chirps'], ['max_chirps' => 20]);

    // Set trial days
    $plan1->trialDays(7);
    $plan2->trialDays(14);

    // Retrieve the trial days
    $trialDays1 = $plan1->trialDays;
    $trialDays2 = $plan2->trialDays;

    // Assert that the trial days are set correctly
    expect($trialDays1)->toBe(7);
    expect($trialDays2)->toBe(14);
});

it('can serialize a plan with trial days with multiple plans', function () {
    // Create a new plan instance with trial days
    $plan1 = PlanCraft::create('pro1', 'Pro Plan 1', '$19', 'monthly', ['20 Chirps'], ['max_chirps' => 20])->trialDays(7);
    $plan2 = PlanCraft::create('pro2', 'Pro Plan 2', '$20', 'monthly', ['20 Chirps'], ['max_chirps' => 20])->trialDays(14);

    // Serialize the plans
    $json1 = json_encode($plan1);
    $json2 = json_encode($plan2);

    // Assert that the JSON contains the trial days property
    expect($json1)->toContain('"trialDays":7');
    expect($json2)->toContain('"trialDays":14');
});
