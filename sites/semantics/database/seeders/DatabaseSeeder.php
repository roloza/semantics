<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CatGrammaticalSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ProfileSeeder::class);
        $this->call(AntonymSeeder::class);
        $this->call(SynonymSeeder::class);
//        $this->call(LexiqueSeeder::class);
    }
}
