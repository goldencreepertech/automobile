<?php

namespace Automobile\Console\Commands;

use Automobile\Database\Seeders\AutomobileSeeder;
use Illuminate\Console\Command;

class InstallCommand extends Command
{
    protected $signature = 'automobile:install
        {--no-seed : Skip seeding the bundled vehicle catalog}
        {--force : Overwrite any published files that already exist}';

    protected $description = 'Install the Automobile package: publish config, run migrations and seed the vehicle catalog';

    public function handle(): int
    {
        $this->components->info('Installing the Automobile package...');

        $this->callSilent('vendor:publish', [
            '--tag' => 'automobile-config',
            '--force' => (bool) $this->option('force'),
        ]);
        $this->components->task('Publish config (config/automobile.php, config/static_token.php)');

        $this->call('migrate', ['--force' => true]);

        if ($this->option('no-seed')) {
            $this->components->warn('Skipping seed (--no-seed). Run "php artisan automobile:seed" later to populate the catalog.');
        } else {
            $this->callSilent('db:seed', [
                '--class' => AutomobileSeeder::class,
                '--force' => true,
            ]);
            $this->components->task('Seed the manufacturer / model / variant / vehicle / part catalog');
        }

        $this->newLine();
        $this->components->info('Automobile package installed.');

        if (config('automobile.routes.enabled', true)) {
            $this->components->bulletList([
                'REST API mounted at "'.config('automobile.routes.prefix', 'api/v1').'/{manufacturers,models,variants,vehicles,parts}"',
                'Set AUTOMOBILE_ROUTES_ENABLED=false to disable the bundled routes.',
                'Static-token auth: set IS_STATIC_TOKEN=true and STATIC_TOKEN=... in your .env, or swap the "auth.static" middleware in config/automobile.php.',
            ]);
        }

        return self::SUCCESS;
    }
}
