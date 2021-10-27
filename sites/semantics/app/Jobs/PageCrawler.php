<?php

namespace App\Jobs;

use App\Models\Job;
use Spatie\Crawler\Crawler;
use App\Custom\CustomCrawler;
use Illuminate\Bus\Queueable;
use App\Custom\Syntex\MakeDecFile;
use Illuminate\Support\Facades\Log;
use App\Custom\Syntex\SyntexWrapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PageCrawler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uuid = $this->job->getJobId();

        Job::create(['uuid' => $uuid, 'user_id' => 1, 'type_id' => 1, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);

        Crawler::create()
            ->setCrawlObserver(new CustomCrawler($uuid, 1))
            ->setTotalCrawlLimit(1)
            ->startCrawling($this->url);

        Job::where('uuid', $uuid)->update(['percentage' => 60, 'message' => 'Analyse linguistique en cours']);
        Log::debug('MakeDecFile');
        (new MakeDecFile($uuid))->run();

        Job::where('uuid', $uuid)->update(['percentage' => 80, 'message' => 'Consolidation des données']);
        Log::debug('SyntexWrapper');
        (new SyntexWrapper($uuid))->run();

        Job::where('uuid', $uuid)->update(['percentage' => 100, 'status_id' => 3, 'message' => 'Traitement terminé']);
    }
}
