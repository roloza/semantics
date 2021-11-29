<?php

namespace App\View\Components\analyse\partials;

use Illuminate\View\Component;

class NetworkGraph extends Component
{

    private $keyword;
    private $uuid;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($keyword, $uuid)
    {
        $this->keyword = $keyword;
        $this->uuid = $uuid;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.partials.network-graph');
    }
}
