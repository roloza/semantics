<?php

namespace App\Jobs;

use App\Models\Job;
use App\Models\Parameters;
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
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;

class SiteCrawler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $params;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uuid = $this->job->getJobId();
        Log::debug('Uuid: ' . $uuid);
        $domain = ucFirst(str_replace("-", ' ' , current(explode(".", str_replace('www.', '', parse_url($this->params['url'], PHP_URL_HOST))))));
        $job = Job::create(['uuid' => $uuid , 'name' => $domain, 'user_id' => $this->params['userId'], 'type_id' => 2, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);
        foreach($this->params as $name => $value) {
            $parameter = Parameters::create(['name' => $name, 'value' => $value]);
            $job->parameters()->attach($parameter->id);
        }

        Crawler::create()
            ->setCrawlObserver(new CustomCrawler($uuid, $this->params['totalCrawlLimit'], $this->params['typeContent']))
            ->setTotalCrawlLimit($this->params['totalCrawlLimit'])
            ->setCrawlProfile(new CrawlInternalUrls($this->params['url']))
            ->startCrawling($this->params['url']);

        Job::where('uuid', $uuid)->update(['percentage' => 60, 'message' => 'Analyse linguistique en cours']);
        Log::debug('MakeDecFile');
        try {
            (new MakeDecFile($uuid))->run();
        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $uuid, 'percentage' => 100, 'status_id' => 4, 'message' => $e->getMessage()]);
            return false;
        }
        Job::where('uuid', $uuid)->update(['percentage' => 80, 'message' => 'Consolidation des données']);

        Log::debug('SyntexWrapper');
        try {
            (new SyntexWrapper($uuid))->run();

        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $uuid, 'percentage' => 100, 'status_id' => 4, 'message' => 'Erreur lors de l\'analyse des données']);
            return false;
        }
        Job::insertUpdate(['uuid' => $uuid, 'percentage' => 100, 'status_id' => 3, 'message' => 'Traitement terminé']);
    }
}
