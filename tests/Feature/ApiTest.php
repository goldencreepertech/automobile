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

    public function test_bundled_routes_are_registered_and_guarded(): void
    {
        $this->getJson('/api/v1/manufacturers')->assertUnauthorized();
        $this->getJson('/api/v1/vehicles')->assertUnauthorized();
    }

    public function test_a_valid_static_token_grants_access(): void
    {
        $this->loadLaravelMigrations();

        Manufacturer::create(['name' => 'Tata Motors']);

        $this->withToken('test-token')
            ->getJson('/api/v1/manufacturers')
            ->assertOk()
            ->assertJsonStructure(['data' => [['id', 'name']]])
            ->assertJsonFragment(['name' => 'Tata Motors']);
    }

    public function test_manufacturers_can_be_created_and_filtered(): void
    {
        $this->loadLaravelMigrations();

        $this->withToken('test-token')
            ->postJson('/api/v1/manufacturers', ['name' => 'Kia'])
            ->assertCreated();

        $this->withToken('test-token')
            ->postJson('/api/v1/manufacturers', ['name' => 'Kia'])
            ->assertStatus(422);

        $this->withToken('test-token')
            ->getJson('/api/v1/manufacturers?name=Ki')
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }
}
