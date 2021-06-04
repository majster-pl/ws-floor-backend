<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'created_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
