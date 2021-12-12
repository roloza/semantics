<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;
use League\Csv\Statement;

class LexiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

    }
}
