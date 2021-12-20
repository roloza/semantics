<?php

namespace App\Http\Livewire\Admin;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Images extends Component
{
    use WithFileUploads;

    public $images, $title, $filename, $image_id;
    public $updateMode = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->images = Image::all();
        return view('livewire.admin.images.index');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $validatedData = $this->validate([
            'filename' => 'required|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
            'title' => '',
        ]);

        $imageName = strtolower($this->filename->getClientOriginalName());
        $slug = $validatedData['title'] ?? '';
        if ($slug === '') {
            $slug = str_replace($this->filename->getClientOriginalExtension(), '', $imageName);
        }
        $validatedData['filename'] = $this->filename->storePubliclyAs('images', $imageName, ['disk' => 'public']);
        $validatedData['slug'] = Str::slug($slug);
        try {
            Image::create($validatedData);
            session()->flash('message', 'Image ajoutée');

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
        $this->title = '';
        $this->filename = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $image = Image::findOrFail($id);
        $this->image_id = $id;
        $this->title = $image->title;
        $this->filename = $image->filename;

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
            'title' => '',
        ]);

        $image = Image::find($this->image_id);
        $image->update($validatedData);

        $this->updateMode = false;

        session()->flash('message', 'Image mise à jour avec succès');
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        $image = Image::find($id);
        $image->delete();
        Storage::disk('public')->delete($image->filename);
        session()->flash('message', 'Image supprimée avec succès');
    }
}
