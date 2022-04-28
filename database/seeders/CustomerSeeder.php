<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\CustomerMeta;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        // Create some Customers
        Customer::factory(20)->create();
    }
}
