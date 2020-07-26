<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Users have 3 possible roles:
     * 0 - SP  - SubmitProduct
     * 1 - AP  - ApproveProduct
     * 2 - SAP - SeeApprovedProduct
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        // Insert same password for every created user
        $password = Hash::make('password');

        // Generate 1 user with the role 0 - SP
        User::create([
            'name'     => 'admin',
            'email'    => 'admin@admin.com',
            'role'     => 0,
            'password' => $password
        ]);

        // Generate 10 users with the role 1 - AP
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'role'     => 1,
                'password' => $password
            ]);
        }

        // Generate 10 users with the role 2 - SAP
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name'     => $faker->name,
                'email'    => $faker->email,
                'role'     => 2,
                'password' => $password
            ]);
        }
    }
}
