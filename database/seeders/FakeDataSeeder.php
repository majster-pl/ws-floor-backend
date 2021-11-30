<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Depot;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_id = Company::create(['name' => 'Company Name'])->id;
        $company_depo1 = Depot::create([
            'name' => 'Bristol',
            'owner_id' => $company_id,
            'email' => 'service.bristol@company-name.com',
        ])->id;

        Depot::create([
            'name' => 'London',
            'owner_id' => $company_id,
            'email' => 'service.london@company-name.com',
        ]);

        $demo_company_id = Company::create(['name' => 'Demo'])->id;
        $demo_depo1 = Depot::create([
            'name' => 'Bristol',
            'owner_id' => $demo_company_id,
            'email' => 'service.bristol@demo.com',
        ])->id;
        Depot::create([
            'name' => 'London',
            'owner_id' => $demo_company_id,
            'email' => 'service.london@demo.com',
        ]);


        User::create([
            'name' => 'Fake User',
            'email' => 'fake@gmail.com',
            'password' => 'password123',
            'owner_id' => $company_id,
            'default_branch' => $company_depo1,
        ]);

        User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'password' => 'demo123',
            'owner_id' => $demo_company_id,
            'default_branch' => $demo_depo1,
        ]);

        // create customers
        Customer::factory(30)->create();

        // create assets
        Asset::factory(40)->create();

        // create bookings
        Event::factory(200)->create();

    }
}
