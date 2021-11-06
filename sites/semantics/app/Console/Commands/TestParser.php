<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Crawler\Crawler;
use App\Custom\TestCrawler;
use App\Models\SeoLink;

class TestParser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test-parser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $urls = [
            // 'https://www.lemonde.fr/international/article/2021/10/27/licences-de-peche-post-brexit-premieres-mesures-de-retorsion-francaises-contre-le-royaume-uni_6100136_3210.html',
            // 'https://www.recette-pateacrepe.fr',
            'https://www.minimachines.net/actu/gpd-xp-android-102895'
        ];

        foreach($urls as $k => $url) {

            Crawler::create()
                ->setCrawlObserver(new TestCrawler($k))
                ->setTotalCrawlLimit(1)
                ->startCrawling($url);
        }

        return Command::SUCCESS;
    }
}
