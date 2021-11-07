<?php


namespace App\Http\Livewire;


use Livewire\Component;
use Livewire\WithPagination;

class TableComponent  extends Component
{
    use WithPagination;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function setOrderField(string $name)
    {
        if ($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function resetFilters()
    {
        $this->reset('orderDirection');
        $this->reset('orderField');
        $this->reset('search');
        $this->reset('category_name');
        $this->reset('longueur');
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'livewire.pagination';
    }

    public function updating($name, $value)
    {
        if ($name === 'search') {
            $this->resetPage();
        }
    }

    public function updateCategory($categoryName)
    {
        $this->category_name = $categoryName;
    }
}
