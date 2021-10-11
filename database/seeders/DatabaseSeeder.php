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
            'name' => 'Glenside'
        ]);

        DB::table('depots')->insert([
            'name' => 'Avonmouth',
            'belongs_to_id' => 1,
        ]);

        DB::table('depots')->insert([
            'name' => 'Gloucester',
            'belongs_to_id' => 1,
        ]);

        DB::table('depots')->insert([
            'name' => 'Swindon',
            'belongs_to_id' => 1,
        ]);

        DB::table('depots')->insert([
            'name' => 'Cardiff',
            'belongs_to_id' => 2,
        ]);

        DB::table('depots')->insert([
            'name' => 'Newport',
            'belongs_to_id' => 2,
        ]);
        DB::table('depots')->insert([
            'name' => 'Krakow',
            'belongs_to_id' => 2,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'belongs_to' => 1,
            'default_depot' => 1,
        ]);


        DB::table('users')->insert([
            'name' => 'Test',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password123'),
            'belongs_to' => 2,
            'default_depot' => 4,
        ]);
        // \App\Models\User::factory(10)->create();

        $this->call([
            CustomerSeeder::class,
            AssetSeeder::class,
            EventSeeder::class,
        ]);
    }
}
