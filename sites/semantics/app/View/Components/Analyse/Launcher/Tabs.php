<?php

namespace App\View\Components\Analyse\Launcher;

use Illuminate\View\Component;

class Tabs extends Component
{
    private $active;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $active)
    {
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.launcher.tabs', [
            'active' => $this->active
        ]);
    }
}
