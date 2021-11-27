<?php

namespace App\Http\Livewire;

use App\Models\Antonym;
use Livewire\Component;

class SearchAntonyms extends Component
{
    public $search = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        return view('livewire.search-antonyms', [
            'results' => Antonym::fuzzySearch($this->search)
        ]);
    }

    public function searchAntonyms($word)
    {
        $this->search = $word;
    }
}
