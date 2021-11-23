<?php

namespace App\Http\Livewire;

use App\Models\Url;
use Livewire\Component;
use App\Models\SyntexRtListe;
use Illuminate\Support\Facades\Session;


class KeywordsSuggestSearch extends Component
{
    public $search = '';
    public $job;
    protected $listeners = ['close'];
    public $display = '';

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        $url = Url::where('uuid', $this->job->uuid)->first();
        $keywords = explode('. ', $url->content);

        if ($this->search !== '') {
            $keywordsFiltered = [];
            foreach($keywords as $keyword) {
                if (str_contains($keyword, $this->search)) {
                    $keywordsFiltered[] = $keyword;
                }
            }
            $keywords = $keywordsFiltered;
        }
        $keywords = array_unique($keywords);
        return view('livewire.keywords-suggest-search', [
            'keywords' => $keywords,
        ]);
    }

    public function showKeyword($keyword)
    {
        $keywordObj = SyntexRtListe::getByUuid($this->job->uuid, $keyword)->first();
        if ($keywordObj !== null) {
            return redirect()->route('analyse.show.keyword', ['type' => $this->job->type->slug, 'uuid' => $this->job->uuid, 'num' => $keywordObj->num]);
        }
        session()->flash('message', 'Mot-clé non trouvé : ' . $keyword);
        $this->display = 'show';
    }


    public function close()
    {
        $this->display = '';
    }
}
