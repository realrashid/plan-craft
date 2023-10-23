<?php

namespace RealRashid\PlanCraft\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = 'plancraft:install {--force : Republish the scaffolding even if they were already published}';

    /**
     * The console command description.
     *
     * @var string
     */
    public $description = 'Initiate the installation process of PlanCraft scaffolding.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Get the --force option value.
        $force = $this->option('force');

        // Define the path to PlanCraftServiceProvider.
        $providerPath = app_path('Providers/PlanCraftServiceProvider.php');

        // Check if PlanCraftServiceProvider is already installed.
        $providerInstalled = file_exists($providerPath);

        // If --force is used, and both config and provider are installed, ask for confirmation.
        if ($force && $providerInstalled) {
            if (! $this->confirm('PlanCraft scaffolding is already installed. Do you want to republish the scaffolding?')) {
                $this->info('Installation process aborted.');

                return;
            }
        }

        // If provider is installed and their are different, ask for confirmation.
        if ($providerInstalled && ! $this->compareServiceProviders()) {
            if (! $this->confirm('The PlanCraftServiceProvider has been modified. Do you want to republish the scaffolding?')) {
                $this->info('Installation process aborted.');

                return;
            }
        }

        // Publish PlanCraft Service Provider.
        $this->comment('Initiating the publication of PlanCraft Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'plancraft-provider', '--force' => $force]);
        $this->info('PlanCraft Service Provider successfully published.');

        // Register PlanCraft service provider in the application configuration file.
        $this->registerPlanCraftServiceProvider('RouteServiceProvider', 'PlanCraftServiceProvider');

        $this->info('PlanCraft scaffolding successfully installed.');

        $this->line('');
        $this->comment('Now, execute the subsequent command to migrate your database:');
        $this->line('php artisan migrate');
    }

    /**
     * Registering the PlanCraft service provider in the application configuration file.
     */
    protected function registerPlanCraftServiceProvider($after, $name): void
    {
        if (! Str::contains($appConfig = file_get_contents(config_path('app.php')), 'App\\Providers\\'.$name.'::class')) {
            file_put_contents(config_path('app.php'), str_replace(
                'App\\Providers\\'.$after.'::class,',
                'App\\Providers\\'.$after.'::class,'.PHP_EOL.'        App\\Providers\\'.$name.'::class,',
                $appConfig
            ));
        }
    }

    /**
     * Compare the contents of the PlanCraftServiceProvider.stub with the installed PlanCraftServiceProvider.
     *
     * @return bool Returns true if the contents match, false otherwise.
     */
    protected function compareServiceProviders(): bool
    {
        // Get the content of the PlanCraftServiceProvider.stub file from stubs directory.
        $stubContent = file_get_contents(__DIR__.'/../../stubs/app/Providers/PlanCraftServiceProvider.stub');

        // Get the content of the installed PlanCraftServiceProvider.
        $installedProviderContent = file_get_contents(app_path('Providers/PlanCraftServiceProvider.php'));

        // Compare the content of the stub with the installed provider.
        return $stubContent === $installedProviderContent;
    }
}
