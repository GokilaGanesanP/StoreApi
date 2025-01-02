<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\store;
use Faker\Factory as Faker;

class storeseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 5) as $index) {
            store::insert([   
               'name' => $faker->company,
               'location' => $faker->city,
            ]);
        }
    }
}
