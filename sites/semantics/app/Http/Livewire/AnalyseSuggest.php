<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;
use Illuminate\Foundation\Bus\DispatchesJobs;

class AnalyseSuggest extends AnalyseComponent
{

    use DispatchesJobs;

    protected $rules = [
        'keyword' => 'required|'
    ];

    public function submit()
    {

        $validatedData = $this->validate();
        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 1;
        $request = new \Illuminate\Http\Request();
        $request->replace([
            'keyword' => $validatedData['keyword'],
            'type' => 'suggest'
        ]);

        $response = app(SemanticsController::class)->store($request);

        $this->uuid = $response->getData()->uuid;

        if ($this->uuid === null) {
            $this->state = ['label' => $response->getData()->message, 'class' => 'btn-danger'];
            $this->active = 4;
        }
        // Add registration data to modal
    }

    public function render()
    {
        return view('livewire.analyse-suggest', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid
        ]);
    }
}
