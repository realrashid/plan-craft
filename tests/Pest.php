<?php

use RealRashid\PlanCraft\PlanCraft;
use RealRashid\PlanCraft\Tests\TestCase;

function createPlans()
{
    PlanCraft::create('basic', 'Basic', '$10', 'Monthly', [
        '10 Chirps',
        '5 Teams',
    ], [
        'max_chirps' => 10,
        'max_teams' => 10,
    ])->description('Basic plan users can create 10 Chirps and Create 5 Teams.');

    PlanCraft::create('pro', 'Pro', '$19', 'Monthly', [
        '20 Chirps',
        '30 Teams',
    ], [
        'max_chirps' => 20,
        'max_teams' => 30,
    ])->description('Pro plan users can create 20 Chirps and Create 30 Teams.');

    PlanCraft::create('unlimited', 'Unlimited', '$19', 'Monthly', [
        'Unlimited Chirps',
        'Unlimited Teams',
    ], [
        'max_chirps' => 0,
        'max_teams' => 0,
    ])->description('Unlimited plan users can perform any action.');
}

uses(TestCase::class)->in(__DIR__);
