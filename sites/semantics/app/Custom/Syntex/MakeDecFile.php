<?php

namespace App\Custom\Syntex;

use App\Models\Url;
use App\Models\Crawler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MakeDecFile
{

    private $uuid;
    private $folder;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->folder ='study/' . $this->uuid . '/';
        $this->path = Storage::disk('local')->path($this->folder);
        Log::debug('path: ' . $this->path);
        // Création du répertoire s'il n'existe pas
        File::isDirectory($this->path) or File::makeDirectory($this->path, 0775, true);
    }

    public function run()
    {
        // Récupération des contenus du job
        $items = Url::where('uuid', $this->uuid)->get();
        $content = '';
        $idDoc = 1;
        // Génération format .dec
        foreach ($items as $item) {
            $content .= '<DOC idDoc="' . $idDoc . '" url="' . $item->url . '" nbLiens="0">' . "\n";
            $verbatimPhrases = explode(".", $item->content);
            $seq = 0;
            $content .= '<SENT idSeq="' . $seq . '" analyse="1" lang="fr">' . "\n";
            $content .= $item->title . '  .' . "\n";
            $content .= '</SENT>' . "\n";
            foreach ($verbatimPhrases as $k => $verbatimPhrase) {
                $seq++;
                $content .= '<SENT idSeq="' . $seq . '" analyse="1" lang="fr">' . "\n";
                $content .= $verbatimPhrase . '  .' . "\n";
                $content .= '</SENT>' . "\n";
            }
            $content .= '</DOC>' . "\n";
            $idDoc++;
        }
        $content = mb_convert_encoding($content, "ISO-8859-1");

        // Enregistrement du fichier à analyser
        Storage::disk('local')->put($this->folder . 'results.dec', $content);

        // Lancement analyse
        shell_exec('/usr/local/scripts/bash/auditfactory-syntex.sh ' . $this->path . ' 2>&1');
    }
}
