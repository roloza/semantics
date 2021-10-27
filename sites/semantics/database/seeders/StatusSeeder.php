<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $names = ['En attente', 'En cours', 'Terminé', 'Erreur'];
        foreach ($names as $name) {
            DB::table('statuses')->insertOrIgnore([
                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        }
    }
}
