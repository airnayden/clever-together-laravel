<?php

namespace Tests\Feature;

use App\Http\Enums\CustomerMetaCodeEnum;
use App\Models\Customer;
use App\Models\Role;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CustomerCrudPositiveTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Always create roles for customers
        $this->seed(RoleSeeder::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_customer_index(): void
    {
        $customer1 = Customer::factory()->create();
        $customer2 = Customer::factory()->create();

        $response = $this->get('/customer');
        $response->assertStatus(200);


        $this->assertSeeCustomerDetails($response, $customer1);
        $this->assertSeeCustomerDetails($response, $customer2);
    }

    /**
     * Test customer search
     *
     * @return void
     */
    public function test_customer_search(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get('/customer?search=' . substr($customer->first_name, 0, 3));
        $response->assertStatus(200);

        $this->assertSeeCustomerDetails($response, $customer);
    }

    /**
     * Test Customer Show
     *
     * @return void
     */
    public function test_customer_show(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get('/customer/' . $customer->id);
        $response->assertStatus(200);

        $this->assertSeeCustomerDetails($response, $customer);
    }

    /**
     * Check customer store. 200 on success. 302 on failed (validation).
     *
     * @return void
     */
    public function test_customer_store(): void
    {
        $data = $this->generateCustomerPostData();

        $response = $this->post('/customer/store', $data);
        $response->assertStatus(200);
    }

    public function test_customer_update(): void
    {
        $customer = Customer::factory()->create();

        $data = $this->generateCustomerPostData();

        $response = $this->post('customer/' . $customer->id . '/update', $data);
        $response->assertStatus(200);
    }

    /**
     * Validate customer delete
     *
     * @return void
     */
    public function test_customer_delete(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->post('/customer/' . $customer->id . '/destroy');

        $response->assertStatus(302);

        $this->assertNull(Customer::find($customer->id));
    }

    /**
     * Check customer details in response
     *
     * @param TestResponse $response
     * @param Customer $customer
     * @return void
     */
    private function assertSeeCustomerDetails(TestResponse $response, Customer $customer): void
    {
        $response->assertSee($customer->first_name);
        $response->assertSee($customer->last_name);
        $response->assertSee($customer->email);

        foreach ($customer->roles as $role) {
            $response->assertSee($role->name);
        }
    }

    /**
     * @return array
     */
    private function generateCustomerPostData(): array
    {
        $meta = [];

        // Set meta
        collect(CustomerMetaCodeEnum::cases())->each(function (CustomerMetaCodeEnum $enum) use (&$meta) {
            $meta[$enum->value] = $this->faker->colorName();
        });

        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password(),
            'roles' => Role::inRandomOrder()->limit(rand(1, 10))->get()->pluck('id')->toArray(),
            'meta' => $meta
        ];
    }
}
