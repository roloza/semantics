<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class Categories extends Component
{

    public $categories, $name, $category_id;
    public $updateMode = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.admin.categories.index');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required'
        ]);

        try {
            Category::create([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name'])
            ]);
            session()->flash('message', 'Catégorie ajoutée');
        } catch (\Exception $e) {
            session()->flash('message', 'Erreur: ' . $e->getMessage());
        }

        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->name = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;

        $this->updateMode = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function cancel()
    {
        $this->updateMode = false;
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $category = Category::find($this->category_id);

        try {
            $category->update([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name'])
            ]);
            session()->flash('message', 'Catégorie ajoutée');
        } catch (\Exception $e) {
            session()->flash('message', 'Erreur: ' . $e->getMessage());
        }

        $this->updateMode = false;

        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Category::find($id)->delete();
        session()->flash('message', 'Catégorie supprimée avec succès');
    }
}
