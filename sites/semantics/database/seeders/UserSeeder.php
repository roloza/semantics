<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Romain Lozach',
            'email' => 'romainloza@gmail.com',
            'password' => Hash::make('password'),
            'profile_id' => 1,
            'count_jobs' => 0,
        ]);
    }
}
