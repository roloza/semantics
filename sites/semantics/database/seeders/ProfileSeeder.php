<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Admin', 'User'];
        foreach ($names as $name) {
            DB::table('profiles')->insertOrIgnore([
                'name' => $name,
            ]);
        }
    }
}
