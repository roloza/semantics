<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;

class AnalyseWeb extends AnalyseComponent
{
    protected $rules = [
        'keyword' => 'required',
        'total_crawl_limit' => '',
        'type_content' => '',
        'is_news' => '',
    ];

    public function submit()
    {

        $validatedData = $this->validate();
        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 1;

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'keyword' => $validatedData['keyword'],
            'total_crawl_limit' => $validatedData['total_crawl_limit'] ?? 10,
            'type_content' => $validatedData['type_content'] ?? 'all',
            'is_news' => $validatedData['is_news'] ?? 0,
            'type' => 'web'
        ]);

        $response = app(SemanticsController::class)->store($request);

        $this->uuid = $response->getData()->uuid;
        // Add registration data to modal
    }

    public function render()
    {
        return view('livewire.analyse-web', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid,
            'totalCrawlLimitValues' => [10,50,100,200,500]
        ]);
    }
}
