<?php

namespace App\Http\Livewire;

use App\Models\CatGrammatical;
use App\Models\SyntexAuditListe;

class DescripteursTable extends TableComponent
{
    public $search = '';
    public $category_name = '';
    public $longueur = [2 => 1, 3 => 1];
    public $orderField = 'score';
    public $orderDirection = 'DESC';
    public $uuid;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_name' => ['except' => ''],
        'orderField' => ['except' => 'score'],
        'orderDirection' => ['except' => 'DESC']
    ];



    public function render()
    {
        $longueurs = [];
        foreach ($this->longueur as $k => $longueur) {
            if ($longueur == 1) {
                $longueurs[] = $k;
            }
        }

        $keywords = SyntexAuditListe::tableUrlDetail(['uuid' => $this->uuid, 'search' => $this->search, 'category_name' => $this->category_name, 'longueur' => $longueurs])
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(20);

        return view('livewire.descripteurs-table', [
            'keywords' => $keywords,
            'categoriesGram' => CatGrammatical::select('name')->groupBy('name')->get()
        ]);
    }
}
