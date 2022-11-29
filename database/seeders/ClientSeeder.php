<?php

namespace Database\Seeders;

use DB;
use Faker\Factory;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $genders = ['male', 'female', 'unspecified'];
        $faker = Factory::create('ru_RU');
        $rows = [];
        for($i = 0; $i < 25; $i++) {
            $rows[] = [
				'full_name' => $faker->name(),
				'phone_number' => $faker->phoneNumber(),
				'address' => $faker->streetAddress(),
				'gender' => $genders[array_rand($genders)]
			]; 
        }
        DB::table('clients')->insert($rows);
    }
}
