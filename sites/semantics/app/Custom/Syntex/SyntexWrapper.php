<?php


namespace App\Custom\Syntex;


use App\Models\Url;
use League\Csv\Reader;
use App\Models\SyntexRtListe;
use App\Models\CatGrammatical;
use App\Models\SyntexAuditDesc;
use App\Models\SyntexAuditIncl;
use App\Models\SyntexAuditListe;
use App\Models\SyntexDescripteur;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

/**
 * Class SyntexWrapper
 * @package App\Custom\Syntex
 */
class SyntexWrapper
{

    /**
     * @var int
     */
    private $uuid;

    private $folder;

    /**
     * SyntexWrapper constructor.
     * @param $uuid
     */
    public function __construct($uuid)
    {
        $this->uuid = $uuid;
        $this->folder = Storage::disk('local')->path('study/' . $this->uuid . '/');
    }

    public function run() {
        $this->resDescripteur();
        $this->rtListe();
        $this->auditListe();
        $this->auditIncl();
        $this->auditDesc();
        $this->auditUrl();
    }

    public function resDescripteur()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/res-descripteur.txt', 'r');
        $csv->setDelimiter("\t");
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record['forme']);
            $lemme = utf8_encode($record['lemme']);
            $cat = utf8_encode($record['cat']);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data = [
                'uuid' => $this->uuid,
                'doc_id' => (int)$record['iddoc'],
                'score' => (int)$record['score'] * 100,
                'score_moy' => (int)$record['score_moy'] * 100,
                'freq' => (int)$record['freq'],
                'titre' => (int)$record['titre'],
                'longueur_num' => (int)$record['longueur'],
                'cat' => $cat,
                'category_name' => ($category !== null) ? $category->name :  'Autres',
                'lemme' => $lemme,
                'forme' => utf8_encode(current($formes)),
                'rang' => (int)$record['rang'],
                'freq_pond' => (float)$record['freq pond'],
                'longueur' => preg_match_all('/\pL+/u',$lemme, $matches)
            ];
            SyntexDescripteur::insertUpdate($data);
        }
    }

    public function rtListe()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/rt_liste.txt', 'r');
        $csv->setDelimiter("\t");

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record[3]);
            $lemme = utf8_encode($record[2]);
            $cat = utf8_encode($record[1]);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data = [
                'uuid' => $this->uuid,
                'num' => (int)$record[0],
                'cat' => $cat,
                'category_name' => ($category !== null) ? $category->name :  'Autres',
                'lemme' => $lemme,
                'forme' => utf8_encode(current($formes)),
                'freq' => (int)$record[5],
                'nb_doc' => (int)$record[6],
                'frequisol' => (int)$record[7],
                'nincl' => (int)$record[14],
                'longueur' => preg_match_all('/\pL+/u',$lemme, $matches)
            ];
            SyntexRtListe::insertUpdate($data);
        }
    }

    public function auditListe()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_liste.txt', 'r');
        $csv->setDelimiter("\t");

        foreach ($csv->getRecords() as $offset => $record) {
            $lemme = trim(str_replace('(v)', '', utf8_encode($record[2])));
            $cat = utf8_encode($record[1]);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data = [
                'uuid' => $this->uuid,
                'num' => (int)$record[0],
                'cat' => $cat,
                'category_name' => ($category !== null) ? $category->name :  'Autres',
                'lemme' => $lemme,
                'longueur_num' => (int)$record[3],
                'longueur' => preg_match_all('/\pL+/u',$lemme, $matches),
                'score' => (int)$record[4],
                'freq_num' => (int)$record[5],
                'nbincl1_num' => (int)$record[6],
                'nbdoc_num' => (int)$record[7],
                'nbdec_num' => (int)$record[8],
            ];
            SyntexAuditListe::insertUpdate($data);
        }
    }

    public function auditIncl()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_incl.txt', 'r');
        $csv->setDelimiter("\t");

        foreach ( $csv->getRecords() as $offset => $record) {
            $data = [
                'uuid' => $this->uuid,
                'num_1' => (int)$record[0],
                'num_2' => (int)$record[1],
            ];
            SyntexAuditIncl::insertUpdate($data);
        }
    }

    public function auditDesc()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_desc.txt', 'r');
        $csv->setDelimiter("\t");

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record[6]);
            $forme = utf8_encode(current($formes));
            $data = [
                'uuid' => $this->uuid,
                'doc_id' => (int)$record[1],
                'num' => (int)$record[2],
                'score' => (int)$record[3] * 100,
                'score_moy' => (int)$record[4] * 100,
                'freq_doc' => (int)$record[5],
                'forme' => $forme,
                'longueur' => preg_match_all('/\pL+/u',$forme, $matches),
            ];
            SyntexAuditDesc::insertUpdate($data);
        }
    }

    public function auditUrl()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_url.txt', 'r');
        $csv->setDelimiter("\t");

        foreach ($csv->getRecords() as $offset => $record) {
            Url::where('uuid', $this->uuid)
                ->where('url', 'LIKE', '%' . $record[2])
                ->update(['doc_id' => $record[1]]);
        }
    }
}
