<?php

namespace App\Http\Livewire;

use App\Models\CatGrammatical;
use App\Models\SyntexAuditListe;
use App\Models\SyntexDescripteur;

class DescripteursByUrlTable extends TableComponent
{

    public $search = '';
    public $category_name = '';
    public $longueur = [2 => 1, 3 => 1];
    public $orderField = 'score_moy';
    public $orderDirection = 'DESC';
    public $job;
    public $url;

    protected $queryString = [
        'search' => ['except' => ''],
        'category_name' => ['except' => ''],
        'orderField' => ['except' => 'score_moy'],
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
        $keywords = SyntexDescripteur::tableUrlDetail(['uuid' => $this->job->uuid, 'doc_id' => $this->url->doc_id, 'search' => $this->search, 'category_name' => $this->category_name, 'longueur' => $longueurs])
            ->orderBy($this->orderField, $this->orderDirection)
            ->paginate(20);

        $bestScore = SyntexDescripteur::where('uuid', $this->job->uuid)->where('doc_id', $this->url->doc_id)->orderBy('score_moy', 'DESC')->first();
        return view('livewire.descripteurs-by-url-table', [
            'keywords' => $keywords,
            'bestScore' => $bestScore->score_moy,
            'categoriesGram' => CatGrammatical::select('name')->groupBy('name')->get()
        ]);
    }

}
