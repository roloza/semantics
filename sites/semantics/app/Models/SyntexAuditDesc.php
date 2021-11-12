<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class SyntexAuditDesc extends Model
{
    use HasFactory;
    use HybridRelations;

    protected $collection = 'syntex_audit_descs';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'doc_id',
        'num',
        'score',
        'score_moy',
        'freq_doc',
        'forme',
        'longueur'
    ];

    public function url(): \Illuminate\Database\Eloquent\Relations\hasOne
    {
        return $this->hasOne(Url::class, 'uuid', 'uuid');
    }

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('doc_id', $data['doc_id'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexAuditDesc] - ' .$e->getMessage());
        }
    }

    public function scopeGetKeywordDocs($query, $uuid, $num)
    {
        $query->where('uuid', $uuid);
        $query->where('num', (int)$num);
        // $query->orderBy('score_moy', 'DESC');
        return $query;
    }

    public static function getNumsSimilaireKeywords($uuid, $keywordDocs, $num)
    {

        $query = self::query();
        $docIds = [];
        foreach ($keywordDocs as $keywordDoc) {
            $docIds[] = $keywordDoc->doc_id;
        }

        $query->where('job_id', $uuid);
        $query->Where('num', '<>', $num);
        $query->whereIn('doc_id', $docIds);

        $response = $query->get();

        $suggests = [];
        foreach ($response as $item) {
            $suggests[$item->num] = [
                'num' => $item->num,
                'forme' => $item->forme,
                'score' => isset($suggests[$item->num]['score']) ? $suggests[$item->num]['score'] + $item->score : $item->score,
                'count' => isset($suggests[$item->num]['count']) ? $suggests[$item->num]['count'] + 1 : 1
            ];
        }

        usort($suggests, function ($item1, $item2) {
            return $item2['score'] <=> $item1['score'];
        });
        $suggests = array_slice($suggests, 0, 20);

        return $suggests;
    }
}
