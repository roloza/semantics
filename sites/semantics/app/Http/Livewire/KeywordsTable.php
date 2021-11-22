<?php

namespace App\Http\Livewire;

use App\Models\CatGrammatical;
use App\Models\SyntexRtListe;

class KeywordsTable extends TableComponent
{

    public $search = '';
    public $category_name = '';
    public $longueur = [2 => 1, 3 => 1];
    public $orderField = 'freq';
    public $orderDirection = 'DESC';
    public $job;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_name' => ['except' => ''],
        'orderField' => ['except' => 'freq'],
        'orderDirection' => ['except' => 'ASC']
    ];

    public function render()
    {
        $longueurs = [];
        foreach ($this->longueur as $k => $longueur) {
            if ($longueur == 1) {
                $longueurs[] = $k;
            }
        }
        $keywords = SyntexRtListe::tableUrlDetail(['uuid' => $this->job->uuid, 'search' => $this->search, 'category_name' => $this->category_name, 'longueur' => $longueurs])
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(20);

        return view('livewire.keywords-table', [
            'keywords' => $keywords,
            'categoriesGram' => CatGrammatical::select('name')->groupBy('name')->get()
        ]);
    }
}
