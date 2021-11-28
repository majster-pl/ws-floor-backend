<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\AssetSeeder;
use Database\Seeders\EventSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            'name' => 'SWTV'
        ]);
        DB::table('companies')->insert([
            'name' => 'Company A'
        ]);

        DB::table('depots')->insert([
            'name' => 'Avonmouth',
            'owner_id' => 1,
            'email' => 'serviceavonmouth@swtv-ltd.com',
        ]);

        DB::table('depots')->insert([
            'name' => 'Gloucester',
            'owner_id' => 1,
            'email' => 'servicegloucester@swtv-ltd.com',
        ]);

        DB::table('depots')->insert([
            'name' => 'Swindon',
            'owner_id' => 1,
            'email' => 'serviceswindon@swtv-ltd.com',
        ]);

        DB::table('depots')->insert([
            'name' => 'Bristol',
            'owner_id' => 2,
            'email' => 'service.bristol@demo.com',
        ]);

        DB::table('depots')->insert([
            'name' => 'London',
            'owner_id' => 2,
            'email' => 'service.london@demo.com',
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'password123',
            'owner_id' => 1,
            'default_branch' => 1,
        ]);


        DB::table('users')->insert([
            'name' => 'Demo User',
            'email' => 'demo@demo.com',
            'password' => 'demo123',
            'owner_id' => 2,
            'default_branch' => 4,
        ]);
        // \App\Models\User::factory(10)->create();

        $this->call([
            CustomerSeeder::class,
            AssetSeeder::class,
            EventSeeder::class,
        ]);
    }
}
