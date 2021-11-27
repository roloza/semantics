<?php

namespace App\Console\Commands;

use League\Csv\Reader;
use League\Csv\Statement;
use Illuminate\Support\Str;
use GuzzleHttp\RequestOptions;
use App\Custom\SynonymeCrawler;
use App\Models\Synonym;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Synonyms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:synonyme';

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
        $csv = Reader::createFromPath(Storage::disk('local')->path('synonymes/thesaurus/thes_fr.dat'), 'r');
        $csv->setDelimiter("|");
        $stmt = Statement::create()
            ->offset(1);
            // ->limit(25);

        $records = $stmt->process($csv);
        $racine = '';
        $data = [];
        $max = 5000;
        foreach ($records as $record) {
            if(count($record) === 2 && is_numeric($record[1])) {
                $racine = strtolower($record[0]);
            }
            else {

                $catGrammatical = strtolower(str_replace(['(', ')'], '', $record[0]));
                unset($record[0]);
                $words = strtolower(implode('|', $record));
                $data[] = [
                    'racine' => $racine,
                    'cat_grammatical' => $catGrammatical,
                    'words' => $words
                ];
            }
        }

        // Si suffisamment de données sont trouvées
        if (count($data) > 30000) {
            Synonym::truncate(); // On vide la table
            $arrays = array_chunk($data, 50);
            foreach($arrays as $array) {
                try {
                    Log::debug('Synonym:: massInsert - ' . sizeof($array));
                    Synonym::insert($array);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
            }
        }

        return Command::SUCCESS;
    }
}
