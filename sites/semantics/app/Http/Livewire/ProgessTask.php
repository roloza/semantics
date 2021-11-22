<?php

namespace App\Http\Livewire;

use App\Models\Job;
use App\Models\Task;
use Livewire\Component;

class ProgessTask extends Component
{
    public $job;

    public function mount($job)
    {
        $this->job = $job;
    }

    public function render()
    {
        $job = Job::where('uuid', $this->job->uuid)->first();
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
