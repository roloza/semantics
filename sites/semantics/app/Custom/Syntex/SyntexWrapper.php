<?php


namespace App\Custom\Syntex;


use App\Models\Job;
use App\Models\Url;
use League\Csv\Reader;
use App\Models\SyntexRtListe;
use App\Models\CatGrammatical;
use App\Custom\Tools\StopWords;
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

    public function run()
    {
        Job::where('uuid', $this->uuid)->update(['percentage' => 80]);
        $this->resDescripteur();
        Job::where('uuid', $this->uuid)->update(['percentage' => 83]);
        $this->rtListe();
        Job::where('uuid', $this->uuid)->update(['percentage' => 86]);
        $this->auditListe();
        Job::where('uuid', $this->uuid)->update(['percentage' => 89]);
        $this->auditIncl();
        Job::where('uuid', $this->uuid)->update(['percentage' => 92]);
        $this->auditDesc();
        Job::where('uuid', $this->uuid)->update(['percentage' => 95]);
        $this->auditUrl();
        Job::where('uuid', $this->uuid)->update(['percentage' => 97]);
    }

    public function runSuggest()
    {
        Job::where('uuid', $this->uuid)->update(['percentage' => 80]);
        $this->resDescripteur();
        Job::where('uuid', $this->uuid)->update(['percentage' => 83]);
        $this->rtListe();
        Job::where('uuid', $this->uuid)->update(['percentage' => 86]);
        $this->auditListe();
        Job::where('uuid', $this->uuid)->update(['percentage' => 89]);
        $this->rtIncl();
        Job::where('uuid', $this->uuid)->update(['percentage' => 92]);
        $this->auditDesc();
        Job::where('uuid', $this->uuid)->update(['percentage' => 95]);
        $this->auditUrl();
        Job::where('uuid', $this->uuid)->update(['percentage' => 97]);
    }

    public function resDescripteur()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/res-descripteur.txt', 'r');
        $csv->setDelimiter("\t");
        $csv->setHeaderOffset(0);

        $data = [];
        $max = 500;

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record['forme']);
            $lemme = utf8_encode($record['lemme']);
            $cat = utf8_encode($record['cat']);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data[] = [
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
                'longueur' => $this->lemmeLength($lemme)
            ];

            if(sizeof($data) > $max) {
                try {
                    Log::debug('SyntexDescripteur::massInsert - ' . sizeof($data));
                    // SyntexDescripteur::insert($data);
                    SyntexDescripteur::upsert($data, ['uuid', 'doc_id', 'lemme']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }
        try {
            Log::debug('SyntexDescripteur::last massInsert - ' . sizeof($data));
            // SyntexDescripteur::insert($data);
            SyntexDescripteur::upsert($data, ['uuid', 'doc_id', 'lemme']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function rtListe()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/rt_liste.txt', 'r');
        $csv->setDelimiter("\t");

        $data = [];
        $max = 500;

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record[3]);
            $lemme = utf8_encode($record[2]);
            $cat = utf8_encode($record[1]);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data[] = [
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
                'longueur' => $this->lemmeLength($lemme)
            ];

            if(sizeof($data) > $max) {
                try {
                    Log::debug('rtListe::massInsert - ' . sizeof($data));
                    // SyntexRtListe::insert($data);
                    SyntexRtListe::upsert($data, ['uuid', 'num']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }

        try {
            Log::debug('rtListe::last massInsert - ' . sizeof($data));
            // SyntexRtListe::insert($data);
            SyntexRtListe::upsert($data, ['uuid', 'num']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function auditListe()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_liste.txt', 'r');
        $csv->setDelimiter("\t");

        $data = [];
        $max = 500;

        foreach ($csv->getRecords() as $offset => $record) {
            $lemme = trim(str_replace('(v)', '', utf8_encode($record[2])));
            $cat = utf8_encode($record[1]);
            $category = CatGrammatical::where('sigle', $cat)->first();
            $data[] = [
                'uuid' => $this->uuid,
                'num' => (int)$record[0],
                'cat' => $cat,
                'category_name' => ($category !== null) ? $category->name :  'Autres',
                'lemme' => $lemme,
                'longueur_num' => (int)$record[3],
                'longueur' => $this->lemmeLength($lemme),
                'score' => (int)$record[4],
                'freq_num' => (int)$record[5],
                'nbincl1_num' => (int)$record[6],
                'nbdoc_num' => (int)$record[7],
                'nbdec_num' => (int)$record[8],
            ];
            if(sizeof($data) > $max) {
                try {
                    Log::debug('auditListe::massInsert - ' . sizeof($data));
                    // SyntexAuditListe::insert($data);
                    SyntexAuditListe::upsert($data, ['uuid', 'num']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }

        try {
            Log::debug('auditListe::last massInsert - ' . sizeof($data));
            // SyntexAuditListe::insert($data);
            SyntexAuditListe::upsert($data, ['uuid', 'num']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function auditIncl()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_incl.txt', 'r');
        $csv->setDelimiter("\t");

        $data = [];
        $max = 500;

        foreach ( $csv->getRecords() as $offset => $record) {
            $data[] = [
                'uuid' => $this->uuid,
                'num_1' => (int)$record[0],
                'num_2' => (int)$record[1],
            ];
            if(sizeof($data) > $max) {
                try {
                    Log::debug('auditIncl::massInsert - ' . sizeof($data));
                    // SyntexAuditIncl::insert($data);
                    SyntexAuditIncl::upsert($data, ['uuid', 'num_1', 'num_2']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }
        try {
            Log::debug('auditIncl::last massInsert - ' . sizeof($data));
        // SyntexAuditIncl::insert($data);
        SyntexAuditIncl::upsert($data, ['uuid', 'num_1', 'num_2']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    public function rtIncl()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/rt_incl.txt', 'r');
        $csv->setDelimiter("\t");

        $data = [];
        $max = 500;

        foreach ( $csv->getRecords() as $offset => $record) {
            Log::debug($record);
            $data[] = [
                'uuid' => $this->uuid,
                'num_1' => (int)$record[0],
                'num_2' => (int)$record[2],
            ];
            if(sizeof($data) > $max) {
                try {
                    Log::debug('rtIncl::massInsert - ' . sizeof($data));
                    // SyntexAuditIncl::insert($data);
                    SyntexAuditIncl::upsert($data, ['uuid', 'num_1', 'num_2']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }
        try {
            Log::debug('rtIncl::last massInsert - ' . sizeof($data));
        // SyntexAuditIncl::insert($data);
        SyntexAuditIncl::upsert($data, ['uuid', 'num_1', 'num_2']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }


    }

    public function auditDesc()
    {
        $csv = Reader::createFromPath($this->folder.'/RESULTAT4_results/audit_desc.txt', 'r');
        $csv->setDelimiter("\t");

        $data = [];
        $max = 500;

        foreach ($csv->getRecords() as $offset => $record) {
            $formes = explode(';', $record[6]);
            $forme = utf8_encode(current($formes));
            $data[] = [
                'uuid' => $this->uuid,
                'doc_id' => (int)$record[1],
                'num' => (int)$record[2],
                'score' => (int)$record[3] * 100,
                'score_moy' => (int)$record[4] * 100,
                'freq_doc' => (int)$record[5],
                'forme' => $forme,
                'longueur' => $this->lemmeLength($forme),
            ];
            if(sizeof($data) > $max) {
                try {
                    Log::debug('auditDesc::massInsert - ' . sizeof($data));
                    // SyntexAuditDesc::insert($data);
                    SyntexAuditDesc::upsert($data, ['uuid', 'num']);
                } catch (\Exception $exception) {
                    Log::error($exception->getMessage());
                }
                $data = [];
            }
        }

        try {
            Log::debug('auditDesc::last massInsert - ' . sizeof($data));
            // SyntexAuditDesc::insert($data);
            SyntexAuditDesc::upsert($data, ['uuid', 'num']);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
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

    /**
     * Calcul la longeur d'une expression
     */
    private function lemmeLength($lemme)
    {
        $items = explode(' ', $lemme);
        $list = [];
        foreach($items as $item)
        {
            if (strlen($item <= 2)) {
                continue;
            }
            if (StopWords::isStopWord($item)) {
                continue;
            }

            $list[] = $item;
        }
        $lemme = implode(' ', $list);

        return preg_match_all('/\pL+/u',$lemme, $matches);
    }
}
