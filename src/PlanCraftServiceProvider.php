<?php

namespace RealRashid\PlanCraft;

use Illuminate\Support\ServiceProvider;
use RealRashid\PlanCraft\Commands\InstallCommand;

class PlanCraftServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->configurePublishing();
            $this->configureCommands();
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations/2023_08_12_000000_create_plans_table.php');
        }
    }

    /**
     * Configure publishing for the package.
     */
    public function configurePublishing()
    {
        $this->publishes([
            __DIR__.'/../stubs/app/Providers/PlanCraftServiceProvider.stub' => app_path('Providers/PlanCraftServiceProvider.php'),
        ], 'plancraft-provider');

    }

    /**
     * Configure the commands.
     */
    public function configureCommands()
    {
        $this->commands([
            InstallCommand::class,
        ]);
    }
}
