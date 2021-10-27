<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatGrammaticalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['sigle' => 'SN', 'name' => 'Syntagme nominal'],
            ['sigle' => 'SV', 'name' => 'Syntagme verbal'],
            ['sigle' => 'SP', 'name' => 'Syntagme'],
            ['sigle' => 'N', 'name' => 'Nom'],
            ['sigle' => 'SVO', 'name' => 'Syntagme verbal'],
            ['sigle' => 'EN', 'name' => 'Entitée nommée'],
            ['sigle' => 'A', 'name' => 'Adjectif'],
            ['sigle' => 'V', 'name' => 'Verbe'],
            ['sigle' => 'SNat', 'name' => 'Syntagme'],
            ['sigle' => 'SA', 'name' => 'Syntagme'],
            ['sigle' => 'AV', 'name' => 'Adverbe'],
            ['sigle' => 'ENAutr', 'name' => 'Entitée nommée'],
            ['sigle' => 'NI', 'name' => 'Autres'],
            ['sigle' => 'SEN', 'name' => 'Entitée nommée'],
            ['sigle' => 'ENPers', 'name' => 'Entitée nommée'],
            ['sigle' => 'SAV', 'name' => 'Syntagme'],
            ['sigle' => 'SNI', 'name' => 'Syntagme'],
            ['sigle' => 'SENAutr', 'name' => 'Entitée nommée'],
            ['sigle' => 'ENSigle', 'name' => 'Sigle'],
            ['sigle' => 'SENPers', 'name' => 'Entitée nommée'],
            ['sigle' => 'ENCorp', 'name' => 'Entitée nommée'],
            ['sigle' => 'SENSigle', 'name' => 'Sigle'],
            ['sigle' => 'ENAdre', 'name' => 'Entitée nommée'],
            ['sigle' => 'EmoNeg', 'name' => 'Autres'],
            ['sigle' => 'SPRO', 'name' => 'Syntagme'],
            ['sigle' => 'EmoPos', 'name' => 'Autres']
        ];
        foreach ($categories as $category) {
            DB::table('cat_grammaticals')->insertOrIgnore($category);
        }
    }
}
