<?php

use App\Models\User;
use RealRashid\PlanCraft\Plan;
use RealRashid\PlanCraft\PlanCraft;

it('creates a plan for the user', function () {
    // Creating plans for testing
    createPlans();

    // Creating a new user
    $user = User::factory()->create();

    // Defining the plan key to be created
    $planKey = 'basic';

    // Calling the createPlan method for the first time with the specified plan key
    $result1 = $user->createPlan($planKey);

    // Verifying the result of the first plan creation is true, indicating successful plan creation
    expect($result1)->toBeTrue();

    // Verifying that the user now has the specified plan associated with them
    expect($user->hasPlan($planKey))->toBeTrue();

    // Defining a different plan key
    $planKey2 = 'premium';

    // Calling the createPlan method again with the different plan key
    $result2 = $user->createPlan($planKey2);

    // Verifying the result of the second plan creation is false, indicating that a new plan was not created
    expect($result2)->toBeFalse();

    // Verifying that the user still has the original plan ('basic') and not the new one ('premium')
    expect($user->hasPlan($planKey2))->toBeFalse();
});

it('can create a new plan by key', function () {
    // Create a user with a specific plan
    $user = User::factory()->create();

    // Create plans for testing
    $planKey = 'pro';
    PlanCraft::create($planKey, 'Pro Plan', '99', 'monthly', [], []);

    // Newly Created Plan for the user
    $created = $user->createPlan($planKey);

    // Check if the user has the 'basic' plan
    expect($created)->toBeTrue(); // Assert that plan creation was successful
    expect($user->hasPlan($planKey))->toBeTrue(); // Assert that user has the plan
});

it('can create a new plan by planId', function () {
    // Create a user with a specific plan
    $user = User::factory()->create();

    // Create plans for testing
    $planKey = 'pro';
    $planId = 'price_1NqHCtKiNV0qopCO5HCZVeAC';
    PlanCraft::create($planKey, 'Pro Plan', '99', 'monthly', [], [], $planId);

    // Newly Created Plan for the user
    $created = $user->createPlan($planKey);

    // Check if the user has the 'basic' plan
    expect($created)->toBeTrue(); // Assert that plan creation was successful
    expect($user->hasPlan($planKey))->toBeTrue(); // Assert that user has the plan
});

it('returns false when user already has a plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic'); // User already has a plan

    // Again trying to create Plan for the user
    $newPlan = $user->createPlan('pro');

    expect($newPlan)->toBeFalse(); // Assert that plan creation failed
    expect($user->hasActivePlan())->toBeTrue(); // Assert that user already has a plan
});

it('returns true when user has an active plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    $hasActivePlan = $user->hasActivePlan();

    expect($hasActivePlan)->toBeTrue(); // Assert that user has an active plan
});

it('returns false when user does not have an active plan', function () {
    // Create a user with a specific plan
    $user = User::factory()->create();

    $hasActivePlan = $user->hasActivePlan();

    expect($hasActivePlan)->toBeFalse(); // Assert that user does not have an active plan
});

it('checks if the user has a specific plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user has the 'basic' plan
    expect($user->hasPlan('basic'))->toBeTrue();
});

it('finds a plan based on a Plan instance', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Find the plan based on the Plan instance
    $plan = $user->findPlan('basic');

    // Assert that a Plan instance is returned
    expect($plan)->toBeInstanceOf(Plan::class);
});

it('gets the details of the user\'s current plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Get the user's current plan
    $currentPlan = $user->currentPlan();

    // Assert that a Plan instance is returned
    expect($currentPlan)->toBeInstanceOf(Plan::class);
});

it('gets features of the user\'s current plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Get the features of the user's current plan
    $features = $user->getPlanFeatures();

    // Assert that an array of features is returned
    expect($features)->toBeArray();
});

it('checks if the user can access a specific feature', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user can access the feature '10 Chirps'
    $canAccess = $user->canAccessFeature('10 Chirps');

    // Assert that the user can access the feature
    expect($canAccess)->toBeTrue();
});

it('checks if the user is eligible to perform a specific action based on their subscription plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user is eligible to perform an action (e.g., 'max_chirps' with a limit of 5)
    $isEligible = $user->checkEligibility('max_chirps', 5);

    // Assert that the user is eligible
    expect($isEligible)->toBeTrue();
});

it('switches the user\'s current plan to a different plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with an existing plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Switch the user's plan to 'pro'
    $switched = $user->switchPlan('pro');

    // Assert that the switch was successful
    expect($switched)->toBeTrue();

    // Assert that the user now has the 'pro' plan
    expect($user->hasPlan('pro'))->toBeTrue();
});

it('switches the user\'s current plan to a different plan by key', function () {
    // Create a user with an existing plan
    $user = User::factory()->create();
    $existingPlanKey = 'basic';
    PlanCraft::create($existingPlanKey, 'Basic Plan', '29', 'monthly', [], []);
    $user->createPlan($existingPlanKey);

    // Create a new plan for switching
    $newPlanKey = 'pro';
    PlanCraft::create($newPlanKey, 'Pro Plan', '99', 'monthly', [], []);

    // Switch to the new plan by key
    $switched = $user->switchPlan($newPlanKey);

    // Check if the switch was successful
    expect($switched)->toBeTrue();
    expect($user->hasPlan($existingPlanKey))->toBeFalse();
    expect($user->hasPlan($newPlanKey))->toBeTrue();
});

it('switches the user\'s current plan to a different plan by planId', function () {
    // Create a user with an existing plan
    $user = User::factory()->create();
    $existingPlanKey = 'basic';
    $existingPlanId = 'price_1NqHCtKiNV0qopCO5HCZVeAC';
    PlanCraft::create($existingPlanKey, 'Basic Plan', '29', 'monthly', [], [], $existingPlanId);
    $user->createPlan($existingPlanKey);

    // Create a new plan for switching
    $newPlanKey = 'pro';
    $newPlanId = 'price_1NqHCtKiNV0qopCO5HCZVeAD';
    PlanCraft::create($newPlanKey, 'Pro Plan', '99', 'monthly', [], [], $newPlanId);

    // Switch to the new plan by planId
    $switched = $user->switchPlan($newPlanId);

    // Check if the switch was successful
    expect($switched)->toBeTrue();
    expect($user->hasPlan($existingPlanKey))->toBeFalse();
    expect($user->hasPlan($newPlanKey))->toBeTrue();
});

it('returns false when trying to switch to the same plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with an existing plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Try to switch to the same plan
    $switched = $user->switchPlan('basic');

    // Check if the switch was not successful
    expect($switched)->toBeFalse();
    expect($user->hasPlan('basic'))->toBeTrue();
});

it('returns false when trying to switch to a non-existent plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with an existing plan
    $user = User::factory()->create();
    $existingPlanKey = 'basic';
    $user->createPlan($existingPlanKey);

    // Try to switch to a non-existent plan
    $nonExistentPlanKey = 'invalid_plan';
    $switched = $user->switchPlan($nonExistentPlanKey);

    // Check if the switch was not successful
    expect($switched)->toBeFalse();
    expect($user->hasPlan($existingPlanKey))->toBeTrue();
});

it('checks if the user has a non-existent plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user has a plan that doesn't exist ('non_existent_plan')
    expect($user->hasPlan('non_existent_plan'))->toBeFalse();
});

it('checks if the user can access a non-existent feature', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user can access a feature that doesn't exist ('non_existent_feature')
    $canAccess = $user->canAccessFeature('non_existent_feature');

    // Assert that the user cannot access the feature
    expect($canAccess)->toBeFalse();
});

it('returns false when checking eligibility of a user with no plan and a non-existent eligibility', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // check if the user is eligible to perform this non-existent action
    $isEligible = $user->checkEligibility('non_existent_eligibility', 5);

    // Assert that the user is not eligible
    expect($isEligible)->toBeFalse();
});

it('returns false when checking eligibility of a user with no plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // check if the user is eligible to perform this action
    $isEligible = $user->checkEligibility('max_chirps', 5);

    // Assert that the user is not eligible
    expect($isEligible)->toBeFalse();
});

it('returns false when checking eligibility of a user with no plan and a valid eligibility key', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // check if the user is eligible to perform this action
    $isEligible = $user->checkEligibility('max_chirps', 5);

    // Assert that the user is not eligible
    expect($isEligible)->toBeFalse();
});

it('returns false when checking eligibility of a user with no plan and a feature with no eligibility limit', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // check if the user is eligible to perform this action
    $isEligible = $user->checkEligibility('max_chirps', 5);

    // Assert that the user is not eligible
    expect($isEligible)->toBeFalse();
});

it('returns null when getting features of a user with no plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // Get the features of the user's current plan
    $features = $user->getPlanFeatures();

    // Assert that null is returned
    expect($features)->toBeNull();
});

it('checks if the user can access a feature with wildcard', function () {
    // Create plans for testing
    PlanCraft::create('pro', 'Basic Plan', '$10', 'monthly', ['create:chirps', 'update:chirps'], ['max_limit' => 5])
        ->description('Initial description.');

    // Create a user with a specific plan that has wildcard feature
    $user = User::factory()->create();
    $user->createPlan('pro');

    // Check if the user can access a feature with wildcard
    $canAccessCreate = $user->canAccessFeature('create:chirps');
    $canAccessUpdate = $user->canAccessFeature('update:chirps');

    // Assert that the user can access the features with wildcard
    expect($canAccessCreate)->toBeTrue();
    expect($canAccessUpdate)->toBeTrue();
});

it('checks if the user is eligible to perform an action with a limit of 0', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan that has eligibility limit of 0
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Check if the user is eligible to perform an action
    $isEligible = $user->checkEligibility('max_chirps', 0);

    // Assert that the user is eligible
    expect($isEligible)->toBeTrue();
});

it('returns false when checking eligibility of a user with no plan and an action with a limit of 0', function () {
    // Create plans for testing
    createPlans();

    // Create a user without a plan
    $user = User::factory()->create();

    // check if the user is eligible to perform this action with a limit of 0
    $isEligible = $user->checkEligibility('max_users', 0);

    // Assert that the user is not eligible
    expect($isEligible)->toBeFalse();
});

it('deletes the user current plan', function () {
    // Create plans for testing
    createPlans();

    // Create a user with a specific plan
    $user = User::factory()->create();
    $user->createPlan('basic');

    // Delete the current plan
    $deleted = $user->deletePlan();

    // Check if the plan was deleted
    expect($deleted)->toBeTrue();
    expect($user->hasActivePlan())->toBeFalse();
});

it('returns false when user does not have a plan to delete', function () {
    // Create a user without a plan
    $user = User::factory()->create();

    // Attempt to delete a plan (which doesn't exist)
    $deleted = $user->deletePlan();

    // Check if the plan was not deleted
    expect($deleted)->toBeFalse();
});
