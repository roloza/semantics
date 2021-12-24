<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AnalyseComponent extends Component
{
    protected $listeners = ['startAnalyse' => 'startAnalyse', 'jobSuccess' => 'jobSuccess', 'jobError' => 'jobError'];
    public $url;
    public $keyword = '';
    public $total_crawl_limit;
    public $is_news = '0';
    public $type_content = 'all';
    public $file = '';
    public $separator = ';';
    public $state = ['label' => 'Lancer', 'class' => 'btn-primary'];
    public $active = 0;
    public $uuid = '';
    public $label = '';

    public function jobSuccess()
    {
        $this->active = 3;
        $this->state = ['label' => 'Terminé', 'class' => 'btn-success'];
    }

    public function jobError()
    {
        $this->active = 4;
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
