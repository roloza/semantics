<?php

namespace App\Console\Commands;

use League\Csv\Reader;
use Illuminate\Support\Str;
use App\Custom\AntonymeCrawler;
use App\Models\Antonym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Antonyms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:antonyme';

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
        // $this->crawlAntonyms();
        $this->csvToSql();
        return Command::SUCCESS;
    }

    public function crawlAntonyms()
    {
        $url = 'http://www.antonyme.org/dictionnaire_des_antonymes/';

        $letters = range('a', 'z');

        $path = storage_path('app/antonymes/letters/');

        foreach ($letters as $letter) {
            if (File::exists($path . $letter . '.csv')) {
                Log::debug('Fichier existe déja : ' . $path . $letter . '.csv');
                continue;
            }
            $urlToCrawl = $url . $letter;
            Log::debug('Crawl: ' . $urlToCrawl);
            \Spatie\Crawler\Crawler::create()
                ->setTotalCrawlLimit(1)
                ->ignoreRobots()
                ->setParseableMimeTypes(['text/html'])
                ->setCrawlObserver(new AntonymeCrawler())
                ->startCrawling($urlToCrawl);
        }

        $files = File::files($path);
        foreach ($files as $file) {
            $reader = Reader::createFromPath($path . $file->getFilename(), 'r');
            $records = $reader->getRecords();
            foreach ($records as $offset => $record) {
                $pathW = storage_path('app/antonymes/words/');
                $name = Str::slug($record[1]) . '.csv';
                if (File::exists($pathW . $name)) {
                    Log::debug('Fichier existe déja : ' . $pathW . $name);
                    continue;
                }
                Log::debug('Crawl: ' . $record[0]);
                \Spatie\Crawler\Crawler::create()
                    ->setTotalCrawlLimit(1)
                    ->ignoreRobots()
                    ->setParseableMimeTypes(['text/html'])
                    ->setCrawlObserver(new AntonymeCrawler($record[1]))
                    ->startCrawling($record[0]);
            }
        }
    }

    public function csvToSql()
    {
        $files = Storage::disk('local')->files('antonymes/words/');
        $data = [];
        $max = 500;
        foreach ($files as $file) {
            $csv = Reader::createFromPath(Storage::disk('local')->path($file), 'r');
            $csv->setDelimiter(",");

            $racine = '';
            $words = [];
            foreach ($csv->getRecords() as $offset => $record) {
                if (count($record) === 2) {
                    if ($racine === '') {
                        $racine = $record[0];
                    }
                    $words[] = $record[1];
                }
            }
            $data[] = [
                'racine' => $racine,
                'words' => implode('|', $words)
            ];

            if(sizeof($data) > $max) {
                try {
                    Log::debug('Antonym::massInsert - ' . sizeof($data));
                    Antonym::upsert($data, ['racine']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }

        try {
            Log::debug('Antonym::last massInsert - ' . sizeof($data));
            Antonym::upsert($data, ['racine']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
