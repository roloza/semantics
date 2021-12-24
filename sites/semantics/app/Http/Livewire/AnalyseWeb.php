<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;

class AnalyseWeb extends AnalyseComponent
{
    protected $rules = [
        'keyword' => 'required',
        'type_content' => '',
        'is_news' => '',
    ];

    public function submit()
    {

        $validatedData = $this->validate();
        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 1;
        $this->label = '';

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'keyword' => $validatedData['keyword'],
            'type_content' => $validatedData['type_content'] ?? 'all',
            'is_news' => $validatedData['is_news'] ?? 0,
            'type' => 'web'
        ]);

        $response = app(SemanticsController::class)->store($request);

        $this->uuid = $response->getData()->uuid;

        if ($this->uuid === null) {
            $this->state = ['label' => $response->getData()->message, 'class' => 'btn-danger'];
            $this->active = 4;
            $this->label = $response->getData()->label;
        }
        // Add registration data to modal
    }

    public function render()
    {
        return view('livewire.analyse-web', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid
        ]);
    }
}
