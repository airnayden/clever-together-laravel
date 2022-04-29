<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\CustomerMeta;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Make sure our DatabaseSeeder is seeding everything right
     *
     * @return void
     */
    public function test_seeded_have_roles_meta()
    {
        $this->seed(DatabaseSeeder::class);

        // Get a random customer
        $customer = Customer::inRandomOrder()->first();
        $role = Role::inRandomOrder()->first();

        $this->assertInstanceOf(Role::class, $role);
        $this->assertInstanceOf(CustomerMeta::class, $customer->meta->first());
        $this->assertInstanceOf(Role::class, $customer->roles->first());
    }
}
