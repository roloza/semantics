<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use App\Models\Faq;
use Illuminate\Support\Str;
use Livewire\Component;

class Faqs extends Component
{

    public $faqs, $name, $icon, $content, $position, $active, $faq_id;
    public $updateMode = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->faqs = Faq::all();
        return view('livewire.admin.faqs.index');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'content' => 'required',
            'icon' => '',
            'position' => 'required',
            'active' => 'required',
        ]);

        try {
            Faq::create([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'icon' => $validatedData['icon'],
                'position' => $validatedData['position'],
                'content' => $validatedData['content'],
                'active' => $validatedData['active'],
            ]);
            session()->flash('message', 'Faq ajoutée');
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
        $this->icon = '';
        $this->position = '';
        $this->content = '';
        $this->active = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        $this->faq_id = $id;
        $this->name = $faq->name;
        $this->content = $faq->content;
        $this->position = $faq->position;
        $this->icon = $faq->icon;
        $this->active = $faq->active;

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
            'content' => 'required',
            'icon' => '',
            'position' => 'required',
            'active' => 'required',
        ]);

        $faq = Faq::find($this->faq_id);

        try {
            $faq->update([
                'name' => $validatedData['name'],
                'slug' => Str::slug($validatedData['name']),
                'icon' => $validatedData['icon'],
                'position' => $validatedData['position'],
                'active' => $validatedData['active'],
            ]);
            session()->flash('message', 'Faq mise à jour avec succès');
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
        Faq::find($id)->delete();
        session()->flash('message', 'Faq supprimée avec succès');
    }
}
