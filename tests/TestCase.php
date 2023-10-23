<?php

namespace RealRashid\PlanCraft\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as Orchestra;
use RealRashid\PlanCraft\PlanCraft;
use RealRashid\PlanCraft\PlanCraftServiceProvider;

class TestCase extends Orchestra
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        PlanCraft::$plans = [];
        PlanCraft::$features = [];
    }

    protected function getPackageProviders($app)
    {
        return [
            PlanCraftServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'sqlite');

        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../tests/Support/database/migrations');
    }
}
