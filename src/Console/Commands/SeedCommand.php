<?php

namespace Automobile\Console\Commands;

use Automobile\Database\Seeders\AutomobileSeeder;
use Illuminate\Console\Command;

class SeedCommand extends Command
{
    protected $signature = 'automobile:seed';

    protected $description = 'Seed the automobile tables with the bundled manufacturer / model / variant / vehicle / part catalog';

    public function handle(): int
    {
        $this->components->info('Seeding the automobile catalog...');

        $this->callSilent('db:seed', [
            '--class' => AutomobileSeeder::class,
            '--force' => true,
        ]);

        $this->components->info('Automobile catalog seeded.');

        return self::SUCCESS;
    }
}
