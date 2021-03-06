<?php

namespace App\Jobs;

use App\Models\Job;
use App\Models\Url;
use GuzzleHttp\Psr7\Uri;
use App\Models\Parameters;
use Spatie\Crawler\Crawler;
use App\Custom\Search\Qwant;
use App\Custom\Search\Searx;
use App\Custom\CustomCrawler;
use Illuminate\Bus\Queueable;
use GuzzleHttp\RequestOptions;
use App\Custom\Search\DuckDuckGo;
use App\Custom\Syntex\MakeDecFile;
use Illuminate\Support\Facades\Log;
use App\Custom\Search\GoogleNewsRss;
use App\Custom\Syntex\SyntexWrapper;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WebCrawler implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $params;
    private $totalCrawlLimit;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->totalCrawlLimit = 30;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->uuid = $this->job->getJobId();
        Log::debug('Uuid: ' . $this->uuid);

        $job = Job::create(['uuid' => $this->uuid, 'name' => ucFirst($this->params['keyword']), 'user_id' => $this->params['userId'], 'type_id' => 3, 'status_id' => 2, 'percentage' => 5, 'message' => 'Initialisation du traitement']);
        foreach($this->params as $name => $value) {
            $parameter = Parameters::create(['name' => $name, 'value' => $value]);
            $job->parameters()->attach($parameter->id);
        }

        if ((bool)$this->params['isNews']) {
            $webCrawler = new GoogleNewsRss($this->params['keyword']);
            $this->getByWebCrawler($webCrawler);
        } else {
            $webCrawler = new Qwant($this->params['keyword']);
            $this->getByWebCrawler($webCrawler);
            $countUrls = Url::where('uuid', $this->uuid)->count();

            if ($countUrls < $this->totalCrawlLimit) {
                $webCrawler = new DuckDuckGo($this->params['keyword']);
                $this->getByWebCrawler($webCrawler);
            }
            $countUrls = Url::where('uuid', $this->uuid)->count();
            if ($countUrls < $this->totalCrawlLimit) {
                $webCrawler = new Searx($this->params['keyword']);
                $this->getByWebCrawler($webCrawler);
            }
        }

        Job::where('uuid', $this->uuid)->update(['percentage' => 60, 'message' => 'Analyse linguistique en cours']);
        Log::debug('MakeDecFile');
        try {
            (new MakeDecFile($this->uuid))->run();
        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 4, 'message' => $e->getMessage()]);
            return false;
        }
        Job::where('uuid', $this->uuid)->update(['percentage' => 80, 'message' => 'Consolidation des donn??es']);

        Log::debug('SyntexWrapper');
        try {
            (new SyntexWrapper($this->uuid))->run();

        } catch(\Exception $e) {
            Log::debug($e->getMessage());
            Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 4, 'message' => 'Erreur lors de l\'analyse des donn??es']);
            return false;
        }
        Job::insertUpdate(['uuid' => $this->uuid, 'percentage' => 100, 'status_id' => 3, 'message' => 'Traitement termin??']);
    }

    public function getByWebCrawler($webCrawler)
    {
        $urls = $webCrawler->search();
        $blackListItems = ['www.bing', 'google', 'wikipedia', 'youtube', 'qwant'];
        foreach ($urls as $url) {
            $countUrls = Url::where('uuid', $this->uuid)->count();
            if ($countUrls >= $this->totalCrawlLimit) {
                break;
            }
            $blacklisted = false;
            foreach ($blackListItems as $blackListItem) {
                if (strpos($url, $blackListItem) !== false) {
                    $blacklisted = true;
                    break;
                }
            }
            if ($blacklisted) {
                continue;
            }
            $uri = new Uri($url);
            $url = $uri->getScheme() . '://' . $uri->getHost() . $uri->getPath();

            Job::where('uuid', $this->uuid)->update([
                'percentage' => min((10 + round((100 * $countUrls / $this->totalCrawlLimit)) / 2), 60),
                'message' => '[' . $countUrls . '/' . $this->totalCrawlLimit . '] ' . (string)$url
            ]);
            Log::debug('[' . $countUrls . '/' . $this->totalCrawlLimit. '] ' . (string)$url);
            Log::debug('Crawl: ' . $url);

            Crawler::create([
                RequestOptions::COOKIES => true,
                RequestOptions::CONNECT_TIMEOUT => 3,
                RequestOptions::TIMEOUT => 3,
                RequestOptions::ALLOW_REDIRECTS => true,
                RequestOptions::HEADERS => [
                    'User-Agent' => "*",
                ]
            ])
            ->setCrawlObserver(new CustomCrawler($this->uuid, 1, $this->params['typeContent']))
            ->setTotalCrawlLimit(1)
            ->ignoreRobots()
            ->setParseableMimeTypes(['text/html'])
            ->startCrawling((string)$url);
        }
    }
}
