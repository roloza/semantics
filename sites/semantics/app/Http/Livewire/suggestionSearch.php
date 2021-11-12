<?php

namespace App\Http\Livewire;

use App\Custom\Tools\StopWords;
use App\Models\SyntexRtListe;
use Livewire\Component;

class SuggestionSearch extends Component
{
    public $search = '';
    public $uuid;

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        $query = new SyntexRtListe();
        // $suggestKeywords = SyntexRtListe::where('uuid', $this->uuid)->paginate(9);
        $query = $query->where('uuid', $this->uuid);
        if ($this->search !== '') {
            $query = $query->where('forme', 'LIKE', "%{$this->search}%");
        }
        $query = $query->whereNotIn('lemme', StopWords::getStopWords());
        $query = $query->orderBy('nincl', 'DESC');
        $suggestKeywords = $query->paginate(9);

        return view('livewire.suggestion-search', [
            'suggestKeywords' => $suggestKeywords,
        ]);
    }


}
