<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Livewire\Component;

class ProgessTask extends Component
{
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }

    public function render()
    {
        $job = Job::where('uuid', $this->uuid)->first();
        if ( $job !== null && $job->status->id === 3) {
            $this->emitUp('jobSuccess');
        } elseif ($job !== null && $job->status->id === 4) {
            $this->emitUp('jobError');
        }
        return view('livewire.progess-task', [
            'job' => $job,
        ]);
    }
}
