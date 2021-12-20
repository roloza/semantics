<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * Class AttachmentTest
 * @package Tests\Feature
 */
class AntonymTest extends TestCase
{

    /**
     * Executé avant les tests
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed --class=AntonymSeeder');
    }

    /**
     * Test si le nombre de synonymes importés est bien celui attendu
     */
    public function testCountSynonyms()
    {
        $antonyms = \App\Models\Antonym::count();
        $this->assertEquals($antonyms, 19381);
    }


    /**
     * Test La recherche Fuzzy
     */
    public function testFuzzySearchSynonym()
    {
        $antonyms = \App\Models\Antonym::fuzzySearch('projet');
        $this->assertIsArray($antonyms);
        $this->assertEquals($antonyms[0]['racine'], 'projet');
        $this->assertEquals($antonyms[0]['words'][0], 'concrétisation');
    }

    /**
     * Test la limite à 1 élément de la recherche Fuzzy
     */
    public function testFuzzySearchSynonymFirst()
    {
        $antonyms = \App\Models\Antonym::fuzzySearch('projet', 1, true);
        $this->assertIsArray($antonyms);
        $this->assertEquals($antonyms['racine'], 'projet');
        $this->assertEquals($antonyms['words'][0], 'concrétisation');
    }

    /**
     * Test la recherche d'une expression
     */
    public function testfuzzySearchByExpressionSearchSynonym()
    {
        $antonyms = \App\Models\Antonym::fuzzySearchByExpression('projet recherche');
        $this->assertIsArray($antonyms);
        $this->assertEquals($antonyms['projet']['racine'], 'projet');
        $this->assertEquals($antonyms['recherche']['racine'], 'recherche');
        $this->assertEquals($antonyms['projet']['words'][0], 'concrétisation');
        $this->assertEquals($antonyms['recherche']['words'][0], 'abandon');
    }

}
