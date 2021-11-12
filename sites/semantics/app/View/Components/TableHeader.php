<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableHeader extends Component
{

    public $direction;
    public $name;
    public $field;
    public $style;

    /**
     * Create a new component instance.
     *
     * @param string $direction
     * @param string $name
     * @param string $field
     * @param string $style
     */
    public function __construct(string $direction, string $name, string $field, string $style = '')
    {
        $this->direction = $direction;
        $this->name = $name;
        $this->field = $field;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table-header', [
            'visible' => $this->field === $this->name,
        ]);
    }
}
