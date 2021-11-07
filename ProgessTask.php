<?php

namespace App\Http\Livewire;

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
     
        return view('livewire.progess-task', [
            'task' => null,
            'time' => time(),
        ]);
    }
}
