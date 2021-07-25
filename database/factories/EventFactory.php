<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('now -7 days', '+31 days');
        return [
            'uuid' => Str::uuid()->toString(),
            'description' => $this->faker->paragraph(1, true),
            'asset_id' => Asset::inRandomOrder()->first()->id,
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'booked_date' => $date->format('Y-m-d'),
            'booked_date_time' => $date,
            'order' => $this->faker->numberBetween(1, 100),
            'created_by' => User::inRandomOrder()->first()->id,
            'allowed_time' => $this->faker->randomDigitNotNull(),
            'status' => 'booked',
        ];
    }
}
