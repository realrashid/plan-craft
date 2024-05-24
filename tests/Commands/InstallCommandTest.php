<?php

it('installs PlanCraft scaffolding when not already installed', function () {
    // Create the PlanCraftServiceProvider file
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), 'Initial Content');
    // Remove PlanCraftServiceProvider.php to simulate it doesn't exist
    unlink(app_path('Providers/PlanCraftServiceProvider.php'));
    $this->artisan('plancraft:install')
        ->expectsOutput('PlanCraft Service Provider successfully published.')
        ->expectsOutput('PlanCraft scaffolding successfully installed.')
        ->expectsOutput('Now, execute the subsequent command to migrate your database:')
        ->assertExitCode(0);

    $this->assertTrue(file_exists(app_path('Providers/PlanCraftServiceProvider.php')));

    // $appConfig = file_get_contents(config_path('app.php'));
    // $this->assertStringContainsString('App\\Providers\\PlanCraftServiceProvider::class', $appConfig);
});

it('aborts installation if PlanCraftServiceProvider is modified and force flag is not used', function () {
    // Create the PlanCraftServiceProvider file
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), 'Initial Content');

    $this->artisan('plancraft:install')
        ->expectsConfirmation('The PlanCraftServiceProvider has been modified. Do you want to republish the scaffolding?', 'no')
        ->expectsOutput('Installation process aborted.')
        ->assertExitCode(0);

    // Add assertions to check if the file remains unchanged
    $this->assertEquals('Initial Content', file_get_contents(app_path('Providers/PlanCraftServiceProvider.php')));
});

it('aborts installation if user chooses not to republish', function () {
    // Create the PlanCraftServiceProvider.php file with content from the stub
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), file_get_contents(__DIR__.'/../../stubs/app/Providers/PlanCraftServiceProvider.stub'));

    $this->artisan('plancraft:install --force')
        ->expectsConfirmation('PlanCraft scaffolding is already installed. Do you want to republish the scaffolding?', 'no')
        ->expectsOutput('Installation process aborted.')
        ->assertExitCode(0);

    $this->assertTrue(file_exists(app_path('Providers/PlanCraftServiceProvider.php')));
});

it('can install scaffolding when force flag is used even if already installed', function () {
    // Create the PlanCraftServiceProvider.php file with content from the stub
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), file_get_contents(__DIR__.'/../../stubs/app/Providers/PlanCraftServiceProvider.stub'));

    $this->artisan('plancraft:install --force')
        ->expectsConfirmation('PlanCraft scaffolding is already installed. Do you want to republish the scaffolding?', 'yes')
        ->expectsOutput('PlanCraft Service Provider successfully published.')
        ->expectsOutput('PlanCraft scaffolding successfully installed.')
        ->expectsOutput('Now, execute the subsequent command to migrate your database:')
        ->assertExitCode(0);

    $this->assertTrue(file_exists(app_path('Providers/PlanCraftServiceProvider.php')));

    // $appConfig = file_get_contents(config_path('app.php'));
    // $this->assertStringContainsString('App\\Providers\\PlanCraftServiceProvider::class', $appConfig);
});

it('aborts installation if PlanCraft scaffolding is modified and not forced', function () {
    // Create the PlanCraftServiceProvider.php file with content from the stub
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), file_get_contents(__DIR__.'/../../stubs/app/Providers/PlanCraftServiceProvider.stub'));

    // Modify the installed PlanCraftServiceProvider file
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), 'Modified Content');

    $this->artisan('plancraft:install')
        ->expectsConfirmation('The PlanCraftServiceProvider has been modified. Do you want to republish the scaffolding?', 'no')
        ->expectsOutput('Installation process aborted.')
        ->assertExitCode(0);

    // Add assertions to check if the file remains unchanged
    $this->assertEquals('Modified Content', file_get_contents(app_path('Providers/PlanCraftServiceProvider.php')));
});

it('installs PlanCraft scaffolding even if PlanCraftServiceProvider is modified when forced', function () {
    // Create the PlanCraftServiceProvider.php file with content from the stub
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), file_get_contents(__DIR__.'/../../stubs/app/Providers/PlanCraftServiceProvider.stub'));

    // Modify the installed PlanCraftServiceProvider file
    file_put_contents(app_path('Providers/PlanCraftServiceProvider.php'), 'Modified Content');

    $this->artisan('plancraft:install --force')
        ->expectsConfirmation('PlanCraft scaffolding is already installed. Do you want to republish the scaffolding?', 'yes')
        ->expectsConfirmation('The PlanCraftServiceProvider has been modified. Do you want to republish the scaffolding?', 'yes')
        ->expectsOutput('PlanCraft Service Provider successfully published.')
        ->expectsOutput('PlanCraft scaffolding successfully installed.')
        ->expectsOutput('Now, execute the subsequent command to migrate your database:')
        ->assertExitCode(0);

    $this->assertTrue(file_exists(app_path('Providers/PlanCraftServiceProvider.php')));

    // $appConfig = file_get_contents(config_path('app.php'));
    // $this->assertStringContainsString('App\\Providers\\PlanCraftServiceProvider::class', $appConfig);
});
