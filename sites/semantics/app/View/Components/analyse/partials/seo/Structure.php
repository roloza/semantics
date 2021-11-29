<?php

namespace App\View\Components\analyse\partials\seo;

use Illuminate\View\Component;

class Structure extends Component
{

    public $audit;
    public $tabName;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($audit, $tabName)
    {
        $this->audit = $audit;
        $this->tabName = $tabName;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.partials.seo.structure');
    }
}
