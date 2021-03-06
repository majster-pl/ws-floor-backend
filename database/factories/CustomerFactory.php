<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid()->toString(),
            'customer_name' => $this->faker->company(),
            'email' => $this->faker->email(),
            'created_by' => User::inRandomOrder()->first()->id,
            'customer_contact' => $this->faker->tollFreePhoneNumber(),
            'status' => $this->faker->randomElement(['active', 'on_hold']),
            'owner_id' => User::inRandomOrder()->first()->owner_id,
        ];
    }
}
