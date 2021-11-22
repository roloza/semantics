<?php

namespace App\Http\Livewire;

use App\Models\Url;

class UrlsTable extends TableComponent
{
    public $search = '';
    public $orderField = 'url';
    public $orderDirection = 'ASC';
    public $job;

    protected $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'url'],
        'orderDirection' => ['except' => 'ASC']
    ];

    public function render()
    {
        return view('livewire.urls-table', [
            'urls' => Url::where('uuid', $this->job->uuid)
                ->where('url', 'LIKE', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate(20),
        ]);
    }


}
