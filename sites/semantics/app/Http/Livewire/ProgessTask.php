<?php

namespace App\Http\Livewire;

use App\Models\Job;
use App\Models\Task;
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
        $job = Job::find($this->uuid);
        if ( $job !== null && $job->status->id === 3) {
            $this->emitUp('jobSuccess');
        } elseif ($job !== null && $job->failed_job !== null) {
            $this->emitUp('jobError');
        }
        return view('livewire.progess-task', [
            'job' => $job,
        ]);
    }
}
