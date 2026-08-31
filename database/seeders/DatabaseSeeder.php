<?php

namespace Database\Seeders;

use App\Models\User;
use Automobile\Database\Seeders\AutomobileSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the demo application: a test user, then the full automobile
     * database (manufacturers, models, variants, vehicles, parts).
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call(AutomobileSeeder::class);
    }
}
