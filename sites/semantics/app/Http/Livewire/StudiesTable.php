<?php

namespace App\Http\Livewire;

use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SemanticsController;

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
        $user = Auth::user();
        if ($user) {
            $query = $query->where('user_id', $user->id);
            if ($this->search !== '') {
                $query = $query->where('name', 'LIKE', "%{$this->search}%");
            }
            $query = $query->orderBy('created_at', 'DESC');
        } else {
            $query = $query->where('user_id', 0);
        }

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
        $job = Job::where('uuid', $uuid)->first();
        $semanticController = new SemanticsController();
        $semanticController->destroy($uuid);

        session()->flash('message', 'Tache supprimée avec succès : ' . $job->type->name . ' - ' . $job->name . '(' . $job->uuid . ')');
    }
}
