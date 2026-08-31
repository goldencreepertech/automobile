<?php

namespace Tests\Feature;

use Automobile\Models\Manufacturer;
use Automobile\Models\Part;
use Automobile\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InstallCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_install_command_runs_without_seeding_when_asked(): void
    {
        $this->artisan('automobile:install', ['--no-seed' => true])
            ->assertSuccessful();

        $this->assertTrue(\Schema::hasTable('vehicles'));
        $this->assertSame(0, Manufacturer::count());
    }

    public function test_seed_command_populates_the_catalog(): void
    {
        $this->artisan('automobile:seed')->assertSuccessful();

        $this->assertGreaterThan(0, Manufacturer::count());
        $this->assertGreaterThan(0, Vehicle::count());
        $this->assertGreaterThan(0, Part::count());

        // Every seeded vehicle is wired to at least one part.
        $this->assertGreaterThan(0, Vehicle::has('parts')->count());
    }
}
