<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Depot;
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
        $date2 = $this->faker->dateTimeBetween('now -3 days', '0 days');
        $company = User::inRandomOrder()->first()->belongs_to;
        return [
            'uuid' => Str::uuid()->toString(),
            'description' => $this->faker->paragraph(1, true),
            'asset_id' => Asset::inRandomOrder()->first()->id,
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'booked_date_time' => $date->setTime(10, 0),
            'arrived_date' => $this->faker->randomElement([null, $date2]),
            'order' => $this->faker->numberBetween(1, 100),
            'created_by' => User::inRandomOrder()->first()->id,
            'allowed_time' => $this->faker->randomDigitNotNull(),
            'belongs_to' => $company,
            'belongs_to_depot' => Depot::where('belongs_to_id', $company)->inRandomOrder()->first()->id,
            'spent_time' => 0,
            'status' => 'booked',
            'free_text' => "#1. Initial comment",
        ];
    }
}
