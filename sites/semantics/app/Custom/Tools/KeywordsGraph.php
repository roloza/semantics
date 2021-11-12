<?php

namespace App\Custom\Tools;

use App\Models\SyntexRtListe;
use App\Models\SyntexAuditIncl;
use Astatroth\LaravelTimer\Timer;

/**
 * Class KeywordsGraph
 * @package App\Custom\Tools
 */
class KeywordsGraph
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
     * Liste des relations entre les mots-clés
     * Exemple : [{ "from": "Lannister", "to": "Tully" }]
     * @var array
     */
    private $edges = [];
    /**
     * Liste des mots-clés à afficher
     * Exemple: [{ "id": "Lannister" }]
     * @var array
     */
    private $nodes = [];

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

    public function getEdges()
    {
        return array_splice($this->edges, 0, $this->maxKeywords);
    }

    public function getNodes()
    {
        return array_splice($this->nodes, 0, $this->maxKeywords);

    }

    /**
     * @return array[]
     */
    public function run()
    {
        Timer::timerStart('timer-name');
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
                $this->makeGraphLvl($candidate,'child', 10);
                $this->makeGraphLvl($candidate,'parent', 10);
            }
        } while ($loop < 3 && (int)Timer::timerRead('timer-name') < 3000);
        if ($this->relationsCount < $this->maxKeywords && (int)Timer::timerRead('timer-name') < 3000) {
            $candidates = $this->getMoreCandidates();
            foreach ($candidates as $candidate) {
                $this->makeGraphLvl($candidate, 'child', 3);
                $this->makeGraphLvl($candidate, 'parent', 3);
            }
        }
    }

    private function makeGraphLvl($keyword, $type = 'child', $max = 10)
    {
        $rtListeKw  = SyntexRtListe::getByUuid($this->uuid, $keyword)->first();
        if ($rtListeKw === null) {
            return;
        }
        if ($type === 'parent') {
            $keywords = $this->getKeywordParentsByNum( $rtListeKw->num);
            $keywordLength = (int)$rtListeKw->longueur-1;
        } else {
            $keywords = $this->getKeywordChildsByNum( $rtListeKw->num);
            $keywordLength = (int)$rtListeKw->longueur+1;
        }

        if (in_array($rtListeKw->forme, $this->keywords)) {
            $this->nodes[] = ['id' => $rtListeKw->forme, 'height' => 50, 'fill' => '#F79210'];
        }
        $cpt = 0;
        foreach ($keywords as $keyword) {
            if ($cpt >= $max) {
                break;
            }
            if ( $keywordLength === (int)$keyword->longueur) {
                $cpt++;
                $this->edges[] = [
                    'from' => $rtListeKw->forme,
                    'to' => $keyword->forme
                ];
                $this->nodes[] = ['id' => $keyword->forme];
                $this->candidates[] = $keyword->forme;
                $this->relationsCount++;
            }
        }
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

    private function getKeywordParentsByNum($num)
    {
        $numParents = SyntexAuditIncl::getParentNums($this->uuid, $num)->get();
        $nums = [];
        foreach ($numParents as $numParent) {
            $nums[] = $numParent->num_1;
        }
        return SyntexRtListe::where('uuid', $this->uuid)->whereIn('num', $nums)->orderBy('freq', 'DESC')->get();
    }

    private function getMoreCandidates()
    {
        $expressions = [];
        foreach ($this->nodes as $node) {
            $items = explode(' ', $node['id']);
            foreach ($items as $item) {
                if (in_array($item, $this->keywords) || strlen($item) < 4) {
                    continue;
                }

                $rtListeKw  = SyntexRtListe::getByUuid($this->uuid, $item)->first();
                if ($rtListeKw === null || in_array($rtListeKw->forme, $this->keywords) || !in_array($rtListeKw->cat, self::CATEGORIES, true)) {
                    continue;
                }
                $expressions[] = $rtListeKw->forme;

                $this->nodes[] = ['id' => $rtListeKw->forme];
                $this->edges[] = [
                    'from' => $node['id'],
                    'to' => $rtListeKw->forme
                ];

            }
        }
        return array_unique($expressions);
    }
}
