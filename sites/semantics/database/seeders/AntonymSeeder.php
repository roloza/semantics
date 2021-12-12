<?php

namespace Database\Seeders;

use App\Models\Antonym;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class AntonymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
