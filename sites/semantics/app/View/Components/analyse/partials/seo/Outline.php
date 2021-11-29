<?php

namespace App\View\Components\analyse\partials\seo;

use Illuminate\View\Component;

class Outline extends Component
{
    private $audit;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($audit)
    {
        $this->audit = $audit;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.partials.seo.outline');
    }
}
