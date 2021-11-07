<?php

namespace App\Http\Livewire;

use App\Http\Controllers\CrawlerController;
use App\Jobs\jobCrawler;
use App\Models\JobStatus;
use App\Models\Task;
use Illuminate\Bus\Dispatcher;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Livewire\Component;

class AnalyseComponent extends Component
{
    use DispatchesJobs;
    protected $listeners = ['startAnalyse' => 'startAnalyse', 'jobSuccess' => 'jobSuccess', 'jobError' => 'jobError'];
    public $url;
    public $type = 'all';
    public $state = ['label' => 'Lancer', 'class' => 'btn-primary'];
    public $active = 0;
    public $uuid = '';

    public function jobSuccess()
    {
        $this->active = 2;
        $this->state = ['label' => 'Terminé', 'class' => 'btn-success'];
    }

    public function jobError()
    {
        $this->active = 3;
        $this->state = ['label' => 'Erreur', 'class' => 'btn-danger'];
    }

    public function mount()
    {
        $this->uuid = md5(uniqid(rand(), true));
    }

    public function updated($propertyName) {

        $this->validateOnly($propertyName);
    }

}
