<?php

namespace App\Http\Livewire;

use App\Http\Controllers\SemanticsController;
use App\Models\Job;

class StudiesTable extends TableComponent
{

    public $search = '';
    public $job;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function render()
    {
        $query = new Job();
        if ($this->search !== '') {
            $query = $query->where('name', 'LIKE', "%{$this->search}%");
        }
        $query = $query->orderBy('created_at', 'DESC');
        $jobs = $query->paginate(20);

        return view('livewire.studies-table', [
            'jobs' => $jobs
        ]);
    }

    /**
     * Suppression d'un job
     */
    public function deleteJob($uuid)
    {
        $job = Job::find($uuid);
        $semanticController = new SemanticsController();
        $semanticController->destroy($uuid);

        session()->flash('message', 'Tache supprimée avec succès : ' . $job->type->name . ' - ' . $job->name . '(' . $job->uuid . ')');
    }
}
