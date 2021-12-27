<?php

namespace App\View\Components\analyse;

use Illuminate\View\Component;

class oneReportBox extends Component
{
    public $labe;
    public $value;
    public $theme;
    public $icon;
    public $size;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $value, $theme, $icon, $size)
    {
        $this->label = $label;
        $this->value = $value;
        $this->theme = $theme;
        $this->icon = $icon;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.one-report-box');
    }
}
