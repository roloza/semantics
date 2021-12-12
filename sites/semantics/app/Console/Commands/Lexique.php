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

class Lexique extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:lexique';

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


        $csv = Reader::createFromPath(Storage::disk('local')->path('lexique/Lexique383.tsv'), 'r');
        $csv->setDelimiter("\t");
        $csv->setHeaderOffset(0);
        $stmt = Statement::create()
            ->offset(1);
//             ->limit(25);

        $records = $stmt->process($csv);

        $racine = '';
        $data = [];
        $max = 100;

        $total = $records->count();
        $current = 0;
        foreach ($records as $record) {
            $data[] = [
                'forme' => $record['ortho'],
                'lemme' => $record['lemme'],
                'phon' => $record['phon'],
                'cat_gram' => $record['cgram'],
                'genre' => $record['genre'],
                'nombre' => $record['nombre'],
                'freq1' => (int)$record['freqlemlivres'],
                'freq2' => (int)$record['freqlemfilms2'],
                'nb_leters' => (int)$record['nblettres'],
                'nb_phons' => (int)$record['nbphons'],
                'nb_syllables' => (int)$record['nbsyll'],
                'cv_cv' => $record['cv-cv'],
                'def_lem' => (int)$record['deflem'],
            ];

            if(count($data) >= $max) {
                $current += count($data);
                try {
                    Log::debug('['. $current .'/' . $total . '] Lexique::massInsert - ' . count($data));
                    \App\Models\Lexique::upsert($data, ['forme', 'lemme', 'cat_gram']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }

        }
        $current += count($data);
        try {
            Log::debug('['. $current .'/' . $total . '] Lexique::last massInsert - ' . count($data));
            \App\Models\Lexique::upsert($data, ['forme', 'lemme', 'cat_gram']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }



//        // Si suffisamment de données sont trouvées
//        if (count($data) > 30000) {
//            Synonym::truncate(); // On vide la table
//            $arrays = array_chunk($data, 50);
//            foreach($arrays as $array) {
//                try {
//                    Log::debug('Synonym:: massInsert - ' . sizeof($array));
//                    Synonym::insert($array);
//                } catch (\Exception $exception) {
//                    Log::error($exception->getMessage());
//                }
//            }
//        }

        return Command::SUCCESS;
    }
}
