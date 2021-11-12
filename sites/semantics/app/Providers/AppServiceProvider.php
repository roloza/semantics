<?php

namespace App\Providers;

use App\Models\Job;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::failing(function (JobFailed $event) {
            Log::error('Erreur execution jon : ' . $event->job->getJobId());
            Job::insertUpdate(['uuid' => $event->job->getJobId(), 'percentage' => 100, 'message' => 'Oops une erreur est survenue', 'status_id' => 4]);
        });
    }
}
