<?php

namespace Database\Seeders;

use DB;
use Faker\Factory;
use App\Models\Client;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('ru_RU');
        $rows = [];
        for($i = 0; $i < 30; $i++) {
            $rows[] = [
                'client_id' => rand(1, 25),
				'brand' => $faker->word(),
				'model' => $faker->word(),
				'color' => $faker->word(),
				'ru_vehicle_registration' => $faker->unique()->lexify('????????')
                ,
                'in_parking' => rand(0, 1) == 1
			]; 
        }
        DB::table('vehicles')->insert($rows);
    }
}
