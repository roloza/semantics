<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Livewire\WithFileUploads;

class AnalyseCustom extends AnalyseComponent
{
    use DispatchesJobs;
    use WithFileUploads;

    protected $rules = [
        'file' => 'required|file|max:102400',
        'separator' => 'required',
    ];

    public function submit()
    {
        $validatedData = $this->validate();

        $this->state = ['label' => 'En cours', 'class' => 'btn-dark'];
        $this->active = 2;

        $request = new \Illuminate\Http\Request();
        $request->replace([
            'filepath' => $validatedData['file']->getRealPath(),
            'filename' => $validatedData['file']->getClientOriginalName(),
            'separator' => $validatedData['separator'],
            'type' => 'custom'
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
        return view('livewire.analyse-custom', [
            'state' => $this->state,
            'active' => $this->active,
            'uuid' => $this->uuid,
        ]);
    }
}
