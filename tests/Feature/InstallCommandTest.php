<?php

namespace Tests\Feature;

use Automobile\Models\Manufacturer;
use Automobile\Models\Part;
use Automobile\Models\Variant;
use Automobile\Models\Vehicle;
use Automobile\Models\VehicleModel;
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

    public function test_seed_command_populates_the_catalog_with_fixed_ids(): void
    {
        $this->artisan('automobile:seed')->assertSuccessful();

        $this->assertSame(51, Manufacturer::count());
        $this->assertSame(175, VehicleModel::count());
        $this->assertSame(410, Variant::count());
        $this->assertSame(410, Vehicle::count());
        $this->assertSame(44, Part::count());

        // ids are the fixed array keys, not an auto-increment sequence
        $this->assertSame('Maruti Suzuki', Manufacturer::find(1)->name);
        $this->assertSame('BMW Motorrad', Manufacturer::find(51)->name);
        $this->assertSame(1, Vehicle::find(1)->variant_id);

        // every vehicle is wired to parts
        $this->assertSame(410, Vehicle::has('parts')->count());
    }

    public function test_reseeding_reproduces_the_same_ids(): void
    {
        $this->artisan('automobile:seed')->assertSuccessful();
        $first = [Manufacturer::max('id'), Variant::max('id'), Part::pluck('name', 'id')->all()];

        $this->artisan('automobile:seed')->assertSuccessful();
        $second = [Manufacturer::max('id'), Variant::max('id'), Part::pluck('name', 'id')->all()];

        $this->assertSame($first, $second);
        $this->assertSame(410, Vehicle::count()); // no duplicates from the second run
    }
}
