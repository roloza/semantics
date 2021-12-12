<?php

namespace Database\Seeders;

use App\Models\Synonym;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;

class SynonymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

    }
}
