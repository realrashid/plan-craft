<?php

use RealRashid\PlanCraft\Plan;

it('can create a plan with all properties', function () {
    // Create a new plan instance
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Assert that all properties are set correctly
    expect($plan->key)->toBe('pro');
    expect($plan->name)->toBe('Pro');
    expect($plan->price)->toEqual((object) ['monthly' => '19', 'yearly' => '228']);
    expect($plan->interval)->toBe(['Monthly', 'Yearly']);
    expect($plan->features)->toBe(['20 Chirps', '30 Teams']);
    expect($plan->eligibilities)->toBe(['max_chirps' => 20, 'max_teams' => 30]);
    expect($plan->planId)->toBe(['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']);
    expect($plan->description)->toBeNull('Pro plan users can create 20 Chirps on per team and Create 30 Teams.');
});

it('can describe a plan', function () {
    // Create a new plan instance
    $plan = new Plan('basic', 'Basic Plan', (object) ['monthly' => 10, 'yearly' => 120], ['Monthly', 'Yearly'], ['feature1', 'feature2'], ['max_limit' => 5], ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']);

    // Describe the plan
    $plan->description('This is a basic plan description.');

    // Assert that the description is set correctly
    expect($plan->description)->toBe('This is a basic plan description.');
});

it('can serialize a plan to JSON', function () {
    // Create a new plan instance
    $plan = new Plan('basic', 'Basic Plan', (object) ['monthly' => 10, 'yearly' => 120], ['Monthly', 'Yearly'], ['feature1', 'feature2'], ['max_limit' => 5], ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']);

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the correct properties
    expect($json)->toContain('"key":"basic"');
    expect($json)->toContain('"name":"Basic Plan"');
    expect($json)->toContain('"price":{"monthly":10,"yearly":120}');
    expect($json)->toContain('"interval":["Monthly","Yearly"]');
    expect($json)->toContain('"features":["feature1","feature2"]');
    expect($json)->toContain('"eligibilities":{"max_limit":5}');
    expect($json)->toContain('"planId":{"monthly":"price_monthly","yearly":"price_yearly"}');
});

it('can create a plan without a planId', function () {
    // Create a new plan instance without specifying a planId
    $plan = new Plan('pro', 'Pro Plan', (object) ['monthly' => 20], ['Monthly'], ['feature3', 'feature4'], ['max_limit' => 10]);

    // Assert that the planId is null
    expect($plan->planId)->toBeNull();
});

it('can describe a plan with a long description', function () {
    // Create a new plan instance
    $plan = new Plan('basic', 'Basic Plan', (object) ['monthly' => 10, 'yearly' => 120], ['Monthly', 'Yearly'], ['feature1', 'feature2'], ['max_limit' => 5], ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']);

    // Describe the plan with a long description
    $plan->description('This is a very long description for the basic plan. It includes detailed information about the features and benefits.');

    // Assert that the description is set correctly
    expect($plan->description)->toBe('This is a very long description for the basic plan. It includes detailed information about the features and benefits.');
});

it('can create a plan with empty features and eligibilities', function () {
    // Create a new plan instance with empty features and eligibilities
    $plan = new Plan('basic', 'Basic Plan', (object) ['monthly' => 10], ['Monthly'], [], []);

    // Assert that the features and eligibilities arrays are empty
    expect($plan->features)->toBe([]);
    expect($plan->eligibilities)->toBe([]);
});

it('can serialize a plan with a null description', function () {
    // Create a new plan instance without setting a description
    $plan = new Plan('basic', 'Basic Plan', (object) ['monthly' => 10, 'yearly' => 120], ['Monthly', 'Yearly'], ['feature1', 'feature2'], ['max_limit' => 5], ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']);

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains a null description
    expect($json)->toContain('"description":null');
});

it('can create a plan with trial days', function () {
    // Create a new plan instance with trial days
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => 19, 'yearly' => 228],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set trial days
    $plan->trialDays(7);

    // Assert that trial days are set correctly
    expect($plan->trialDays)->toBe(7);
});

it('can create a plan without trial days', function () {
    // Create a new plan instance without specifying trial days
    $plan = new Plan(
        'basic',
        'Basic',
        (object) ['monthly' => 10, 'yearly' => 120],
        ['Monthly', 'Yearly'],
        ['feature1', 'feature2'],
        ['max_limit' => 5],
        ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']
    );

    // Assert that trial days are null
    expect($plan->trialDays)->toBeNull();
});

it('can serialize a plan with trial days', function () {
    // Create a new plan instance with trial days
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => 19, 'yearly' => 228],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set trial days
    $plan->trialDays(7);

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the trial days property
    expect($json)->toContain('"trialDays":7');
});

it('can serialize a plan without trial days', function () {
    // Create a new plan instance without specifying trial days
    $plan = new Plan(
        'basic',
        'Basic',
        (object) ['monthly' => 10, 'yearly' => 120],
        ['Monthly', 'Yearly'],
        ['feature1', 'feature2'],
        ['max_limit' => 5],
        ['monthly' => 'price_monthly', 'yearly' => 'price_yearly']
    );

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains "trialDays" set to null
    expect($json)->toContain('"trialDays":null');
});

it('can set monthly incentive', function () {
    // Create a new plan instance
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set monthly incentive
    $plan->monthlyIncentive('Save 10%');

    // Assert that the monthly incentive is set correctly
    expect($plan->monthlyIncentive)->toBe('Save 10%');
});

it('can set yearly incentive', function () {
    // Create a new plan instance
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set yearly incentive
    $plan->yearlyIncentive('Save 10%');

    // Assert that the yearly incentive is set correctly
    expect($plan->yearlyIncentive)->toBe('Save 10%');
});

it('can serialize a plan with monthly incentive', function () {
    // Create a new plan instance with monthly incentive
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set monthly incentive
    $plan->monthlyIncentive('Save 10%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the monthly incentive property
    expect($json)->toContain('"monthlyIncentive":"Save 10%"');
});

it('can serialize a plan with yearly incentive', function () {
    // Create a new plan instance with yearly incentive
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set yearly incentive
    $plan->yearlyIncentive('Save 10%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the yearly incentive property
    expect($json)->toContain('"yearlyIncentive":"Save 10%"');
});

it('can create a plan with monthly and yearly prices', function () {
    // Create a new plan instance with both monthly and yearly prices
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Assert that both monthly and yearly prices are set correctly
    expect($plan->price->monthly)->toBe('19');
    expect($plan->price->yearly)->toBe('228');
});

it('can set and retrieve monthly and yearly incentives', function () {
    // Create a new plan instance
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set monthly and yearly incentives
    $plan->monthlyIncentive('Save 10%');
    $plan->yearlyIncentive('Save 15%');

    // Assert that incentives are set correctly
    expect($plan->monthlyIncentive)->toBe('Save 10%');
    expect($plan->yearlyIncentive)->toBe('Save 15%');
});

it('can serialize a plan with incentives', function () {
    // Create a new plan instance with incentives
    $plan = new Plan(
        'pro',
        'Pro',
        (object) ['monthly' => '19', 'yearly' => '228'],
        ['Monthly', 'Yearly'],
        ['20 Chirps', '30 Teams'],
        ['max_chirps' => 20, 'max_teams' => 30],
        ['monthly' => 'price_1NqHCtKiNV0qopCO5HCZVeAC', 'yearly' => 'price_yearly']
    );

    // Set monthly and yearly incentives
    $plan->monthlyIncentive('Save 10%');
    $plan->yearlyIncentive('Save 15%');

    // Serialize the plan
    $json = json_encode($plan);

    // Assert that the JSON contains the incentives properties
    expect($json)->toContain('"monthlyIncentive":"Save 10%"');
    expect($json)->toContain('"yearlyIncentive":"Save 15%"');
});
