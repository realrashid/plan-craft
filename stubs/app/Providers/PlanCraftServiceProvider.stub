<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RealRashid\PlanCraft\Facades\PlanCraft;

class PlanCraftServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->definePlans();
    }

    protected function definePlans(): void
    {
        PlanCraft::create('basic', 'Basic', '10|120', 'Monthly|Yearly', [
            '10 Chirps',
            '5 Teams',
        ], [
            'max_chirps' => 10,
            'max_teams' => 5,
        ], 'price_monthly|price_yearly')->description('Basic plan users can create 10 Chirps on per team and Create 5 Teams.');

        PlanCraft::create('pro', 'Pro', '19|228', 'Monthly|Yearly', [
            '20 Chirps',
            '30 Teams',
        ], [
            'max_chirps' => 20,
            'max_teams' => 30,
        ], 'price_monthly|price_yearly')->description('Pro plan users can create 20 Chirps on per team and Create 30 Teams.');

        PlanCraft::create('unlimited', 'Unlimited', '50|600', 'Monthly|Yearly', [
            'Unlimited Chirps',
            'Unlimited Teams',
        ], [
            'max_chirps' => 0,
            'max_teams' => 0,
        ], 'price_monthly|price_yearly')->description('Unlimited plan users can create unlimited.');
    }
}
