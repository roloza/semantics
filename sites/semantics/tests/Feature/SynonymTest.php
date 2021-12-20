<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

/**
 * Class AttachmentTest
 * @package Tests\Feature
 */
class SynonymTest extends TestCase
{

    /**
     * Executé avant les tests
     */
    public function setUp(): void
    {
        parent::setUp();
        Artisan::call('migrate');
        Artisan::call('db:seed --class=SynonymSeeder');
    }

    /**
     * Test si le nombre de synonymes importés est bien celui attendu
     */
    public function testCountSynonyms()
    {
        $synonyms = \App\Models\Synonym::count();
        $this->assertEquals($synonyms, 36270);
    }


    /**
     * Test La recherche Fuzzy
     */
    public function testFuzzySearchSynonym()
    {
        $synonyms = \App\Models\Synonym::fuzzySearch('projet');
        $this->assertIsArray($synonyms);
        $this->assertEquals($synonyms[0]['racine'], 'projet');
        $this->assertEquals(current($synonyms[0]['words']), 'ébauche');
    }

    /**
     * Test la limite à 1 élément de la recherche Fuzzy
     */
    public function testFuzzySearchSynonymFirst()
    {
        $synonyms = \App\Models\Synonym::fuzzySearch('projet', 1, true);
        $this->assertIsArray($synonyms);
        $this->assertEquals($synonyms['racine'], 'projet');
        $this->assertEquals(current($synonyms['words']), 'ébauche');
    }

    /**
     * Test la recherche d'une expression
     */
    public function testfuzzySearchByExpressionSearchSynonym()
    {
        $synonyms = \App\Models\Synonym::fuzzySearchByExpression('projet recherche');
        $this->assertIsArray($synonyms);
        $this->assertEquals($synonyms['projet']['racine'], 'projet');
        $this->assertEquals($synonyms['recherche']['racine'], 'recherche');
        $this->assertEquals($synonyms['projet']['words'][0], 'ébauche');
        $this->assertEquals($synonyms['recherche']['words'][0], 'apprêt');
    }

}
