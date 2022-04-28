<?php

namespace Database\Factories;

use App\Http\Enums\CustomerMetaCodeEnum;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make($this->faker->password())
        ];
    }

    /**
     * @return CustomerFactory
     */
    public function configure(): CustomerFactory
    {
        return $this->afterCreating(function (Customer $customer) {
            $customer->roles()->attach(Role::inRandomOrder()->first()->id);

            $meta = [];

            foreach (CustomerMetaCodeEnum::cases() as $metaCode) {
                $meta[] = [
                    'code' => $metaCode->value,
                    'value' => $this->faker->word
                ];
            }

            $customer->meta()->createMany($meta);
        });
    }
}
