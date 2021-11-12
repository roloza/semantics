<?php

namespace App\Custom\Tools;

use App\Models\SyntexAuditIncl;
use App\Models\SyntexRtListe;

/**
 * Class KeywordsGraph
 * @package App\Custom\Tools
 */
class KeywordsGraphV2
{


    /**
     * Identifiant de la tache
     * @var string
     */
    private $uuid;
    /**
     * Mots-clés
     * @var array
     */
    private $keywords;

     /**
     * Liste de mots-clés candidats pour recherche d'enfants
     * @var array
     */
    private $candidates = [];

    /**
     * Nombre de relations identifiées
     * @var int
     */
    private $relationsCount = 0;

    /**
     * Nombre max d'éléments qui seront retournés
     * @var int
     */
    private $maxKeywords;

    /**
     * Liste des catégories grammaticales acceptées
     */
    private const CATEGORIES = ['N', 'V', 'A'];

    private $data = [];

    /**
     * KeywordsGraph constructor.
     * @param $uuid
     * @param $keywords
     * @param int $maxKeywords
     */
    public function __construct($uuid, $keywords, $maxKeywords = 100)
    {
        $this->keywords = [];
        $rtListKw = SyntexRtListe::getByUuid($uuid, $keywords)->first();


        if ($rtListKw!== null) {
            $this->keywords[] = $rtListKw->forme;
            $items = explode(' ', $rtListKw->lemme);
            foreach ($items as $item) {
                if (!StopWords::isStopWord($item)) {
                    $this->keywords[] = $item;
                }
            }

            $this->keywords = array_unique($this->keywords);
        }

        $this->uuid = $uuid;
        $this->maxKeywords = $maxKeywords;
    }

    public function run()
    {
        foreach ($this->keywords as $keyword) {

            foreach ($this->keywords as $keyword) {
                $this->makeGraphLvl($keyword, 'child', 20);
                $this->makeGraphLvl($keyword, 'parent', 20);
            }

            $loop = 0;
            do {
                $loop++;
                $candidates = $this->candidates;
                $this->candidates = [];
                foreach ($candidates as $candidate) {
                    $this->makeGraphLvl($candidate, 'child', 10);
                }
            } while ($loop < 2 );
        }

        // dd($this->data);
        return json_encode($this->data);

    }

    private function getKeywordChildsByNum($num)
    {
        $numEnfants = SyntexAuditIncl::getChildNums($this->uuid, $num)->get();
        $nums = [];
        foreach ($numEnfants as $numEnfant) {
            $nums[] = $numEnfant->num_2;
        }
        return SyntexRtListe::where('uuid', $this->uuid)->whereIn('num', $nums)->orderBy('freq', 'DESC')->get();
    }

    private function getKeywordParentssByNum($num)
    {
        $numParents = SyntexAuditIncl::getParentNums($this->uuid, $num)->get();
        $nums = [];
        foreach ($numParents as $numParent) {
            $nums[] = $numParent->num_1;
        }
        return SyntexRtListe::where('uuid', $this->uuid)->whereIn('num', $nums)->orderBy('freq', 'DESC')->get();
    }

    private function makeGraphLvl($keyword, $type = 'child', $max = 10)
    {
        $rtListeKw  = SyntexRtListe::getByUuid($this->uuid, $keyword)->first();
        if ($rtListeKw === null) {
            return;
        }

        if ($type === 'parent') {
            $keywords = $this->getKeywordParentssByNum( $rtListeKw->num);
            $lenghtKeyword = (int)$rtListeKw->longueur-1;
        } else {
            $keywords = $this->getKeywordChildsByNum( $rtListeKw->num);
            $lenghtKeyword = (int)$rtListeKw->longueur+1;
        }


        $cpt = 0;
        foreach ($keywords as $keyword) {
            if ($cpt >= $max) {
                break;
            }

            if (((int)$rtListeKw->longueur > 1 || $lenghtKeyword === (int)$keyword->longueur)) {
                $cpt++;

                $this->data[] = [$rtListeKw->forme, $keyword->forme];
                $this->candidates[] = $keyword->forme;
                $this->relationsCount++;
            }
        }
    }
}

