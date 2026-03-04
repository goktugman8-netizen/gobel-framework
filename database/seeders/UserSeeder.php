<?php

namespace Database\Seeders;

use Gobel\Database\Seeder;
use Gobel\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->insert([
        //     'name' => $this->faker->name,
        //     'email' => $this->faker->unique()->safeEmail,
        //     'password' => password_hash('password', PASSWORD_BCRYPT),
        // ]);
    }
}