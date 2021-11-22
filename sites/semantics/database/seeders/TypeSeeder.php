<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = ['Page', 'Site', 'Web', 'Custom', 'Suggest'];
        foreach ($names as $name) {
            DB::table('types')->insertOrIgnore([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }
    }
}
