<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AnalyseSite extends AnalyseComponent
{

    use DispatchesJobs;

    protected $rules = [
        'url' => 'required|url',
        'type_content' => '',
        'total_crawl_limit' => '',
    ];

    public function submit()
    {

        $validatedData = $this->validate();
        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 1;
        $request = new \Illuminate\Http\Request();
        $request->replace([
            'url' => $validatedData['url'],
            'total_crawl_limit' => $validatedData['total_crawl_limit'] ?? 10,
            'type_content' => $validatedData['type_content'] ?? 'all',
            'type' => 'site'
        ]);

        $response = app(SemanticsController::class)->store($request);

        $this->uuid = $response->getData()->uuid;
        // Add registration data to modal
    }

    public function render()
    {
        return view('livewire.analyse-site', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid,
            'totalCrawlLimitValues' => [10,50,100,200,500],
        ]);
    }
}
