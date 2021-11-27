<?php

namespace App\Http\Livewire;

use livewire;
use App\Models\Synonym;
use Livewire\Component;

class SearchSynonyms extends Component
{
    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        return view('livewire.search-synonyms', [
            'results' => Synonym::fuzzySearch($this->search)
        ]);
    }

    public function searchSynonyms($word)
    {
        $this->search = $word;
    }
}
