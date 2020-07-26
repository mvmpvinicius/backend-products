<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        $faker = \Faker\Factory::create();

        // Generate 20 fake products to be approved
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name'        => $faker->sentence,
                'description' => $faker->paragraph,
                'status'      => 0
            ]);
        }

        // Generate 20 fake products approved
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name'        => $faker->sentence,
                'description' => $faker->paragraph,
                'status'      => 1
            ]);
        }
    }
}
