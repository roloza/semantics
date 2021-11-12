<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AnalysePage extends AnalyseComponent
{
    use DispatchesJobs;

    protected $rules = [
        'url' => 'required|url',
        'type_content' => '',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 2;

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'url' => $validatedData['url'],
            'type_content' => $validatedData['type_content'] ?? 'all',
            'type' => 'page'
        ]);
        $response = app(SemanticsController::class)->store($request);

        $this->uuid = $response->getData()->uuid;
        // Add registration data to modal
    }

    public function render()
    {
        return view('livewire.analyse-page', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid,
        ]);
    }
}
