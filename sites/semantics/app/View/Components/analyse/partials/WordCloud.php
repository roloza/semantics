<?php

namespace App\View\Components\analyse\partials;

use Illuminate\View\Component;

class WordCloud extends Component
{

    private $data;
    private $name;
    private $showMore;
    private $dataGraph;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($data, $name, $showMore, $dataGraph)
    {
        $this->data = $data;
        $this->name = $name;
        $this->showMore = $showMore;
        $this->dataGraph = $dataGraph;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.analyse.partials.word-cloud');
    }
}
