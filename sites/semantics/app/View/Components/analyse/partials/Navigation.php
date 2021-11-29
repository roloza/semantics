<?php

namespace App\View\Components\analyse\partials;

use Illuminate\View\Component;

class Navigation extends Component
{

    private $uuid;
    private $num;
    private $url;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($uuid, $num = null, $url = null)
    {
        $this->uuid = $uuid;
        $this->num = $num;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.partials.navigation');
    }
}
