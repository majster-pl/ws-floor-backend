<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reg' => strtoupper($this->faker->bothify('??##???')),
            'uuid' => Str::uuid()->toString(),
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'status' => $this->faker->randomElement(['active', 'on_hold']),
            'created_by' => User::inRandomOrder()->first()->id,
            'belongs_to' => Customer::inRandomOrder()->first()->id,
        ];
    }
}
