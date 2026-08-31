<?php

namespace Tests\Feature;

use Automobile\Models\Manufacturer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_package_migrations_create_the_domain_tables(): void
    {
        $this->assertTrue(\Schema::hasTable('manufacturers'));
        $this->assertTrue(\Schema::hasTable('models'));
        $this->assertTrue(\Schema::hasTable('variants'));
        $this->assertTrue(\Schema::hasTable('vehicles'));
        $this->assertTrue(\Schema::hasTable('parts'));
        $this->assertTrue(\Schema::hasTable('part_vehicle'));
    }

    public function test_bundled_routes_are_registered(): void
    {
        $this->getJson('/api/v1/manufacturers')->assertOk();
        $this->getJson('/api/v1/vehicles')->assertOk();
    }

    public function test_manufacturers_can_be_listed_created_and_filtered(): void
    {
        Manufacturer::create(['name' => 'Tata Motors']);

        $this->getJson('/api/v1/manufacturers')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name']]])
            ->assertJsonFragment(['name' => 'Tata Motors']);

        $this->postJson('/api/v1/manufacturers', ['name' => 'Kia'])->assertCreated();
        $this->postJson('/api/v1/manufacturers', ['name' => 'Kia'])->assertStatus(422);

        $this->getJson('/api/v1/manufacturers?name=Ki')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }
}
