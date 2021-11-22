<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexAuditListe extends Model
{
    use HasFactory;


    protected $table = 'syntex_audit_listes';
    // protected $collection = 'syntex_audit_listes';
    // protected $connection = 'mongodb';
    // protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'num',
        'cat',
        'lemme',
        'longueur_num',
        'score',
        'freq_num',
        'nbincl1_num',
        'nbdoc_num',
        'nbdec_num',
        'longueur_num',
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexAuditListe] - ' .$e->getMessage());
        }
    }

    public function scopeGetBestKeywords($query, $uuid)
    {
        $query->where('uuid', $uuid);
        $query->whereIn('cat', ['SN', 'SV']);
        return $query;
    }

    public function scopeGetAuditList($query, $uuid)
    {
        $query->where('uuid', $uuid);
        $query->whereIn('cat', ['SN', 'SV', 'N', 'V']);
        $query->orderBy('score', 'DESC');
        $query->take(75);
        return $query;
    }

    public static function getDataWordCloud($uuid)
    {
        $data = [];
        $auditList = self::getAuditList($uuid)->get();

        $dataWordCloud = [];
        foreach ($auditList as $keyword) {

            $data[] = [
                'name' => $keyword->lemme,
                'weight' => (int)$keyword->score
            ];

        }
        return json_encode($data);
    }

    public function scopeTableUrlDetail($query, $params)
    {
        if (isset($params['uuid']) && $params['uuid'] !== '') {
            $query->where('uuid', $params['uuid']);
        }
        if (isset($params['search']) && $params['search'] !== '') {
            $query->where('lemme', 'LIKE', "%{$params['search']}%");
        }
        if (isset($params['category_name']) && $params['category_name'] !== '') {
            $query->where('category_name',  $params['category_name']);
        }
        if (isset($params['longueur']) && $params['longueur'] !== '') {
            $query->whereIn('longueur',  $params['longueur']);
        }
        return $query;
    }
}
