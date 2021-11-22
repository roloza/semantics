<?php

namespace App\Models;

use App\Custom\Tools\StopWords;
use Illuminate\Support\Facades\Log;
// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexRtListe extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'syntex_rt_listes';
    // protected $collection = 'syntex_rt_listes';
    // protected $connection = 'mongodb';
    // protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'num',
        'cat',
        'lemme',
        'forme',
        'freq',
        'nb_doc',
        'frequisol',
        'nincl',
        'longueur'
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexRtListe] - ' .$e->getMessage());
        }
    }

    public function scopeCountBy($query, $uuid, $param = 'all')
    {
        $query->where('uuid', $uuid);
        if ($param === 'syntagmes') {
            $query->whereIn('cat', ['SN', 'SV', 'SP']);
        }
        return $query;
    }

    public function scopeGetBestKeywordByLength($query, $uuid)
    {
        $query->select('forme');
        $query->where('uuid', $uuid);
        $query->whereIn('cat', ['V', 'N']);
//        $query->whereNotIn('lemme', ['être', 'avoir']);
        $query->orderBy('nincl', 'DESC');
        return $query;
    }

    public function scopeGetByUuid($query, $uuid, $keywords)
    {
        $query->where('uuid', $uuid);
        $query->where('forme', $keywords);
        return $query;
    }

    public function scopeTableUrlDetail($query, $params)
    {
        if (isset($params['uuid']) && $params['uuid'] !== '') {
            $query->where('uuid', $params['uuid']);
        }
        if (isset($params['search']) && $params['search'] !== '') {
            $query->where('forme', 'LIKE', "%{$params['search']}%");
        }
        if (isset($params['category_name']) && $params['category_name'] !== '') {
            $query->where('category_name', $params['category_name']);
        }
        if (isset($params['longueur']) && $params['longueur'] !== '') {
            $query->whereIn('longueur', $params['longueur']);
        }
        return $query;
    }

    public function scopeGetIncludings($query, $uuid, $keyword)
    {
        $query->where('uuid', $uuid);
        $query->where('lemme', 'LIKE', '%' . $keyword->lemme . '%');
        $query->where('lemme', '<>',  $keyword->lemme);
//        $query->orderBy('longueur');
        $query->orderBy('freq', 'DESC');
        return $query;
    }


    public static function getIncludeds($uuid, $keyword)
    {

        $items = explode(' ', $keyword->lemme);
        $includedsByKeywords = [];
        foreach ($items as $item) {
            if (StopWords::isStopWord($item)) {
                continue;
            }
            $query = self::query();
            $query->where('uuid', $uuid);
            $query->where('lemme', '<>',  $keyword->lemme);
            $query->where('lemme', 'LIKE', '%' . $item . '%');
            $query->whereIn('longueur', [2, 3]);
            $query->orderBy('freq', 'DESC');
            $includedsByKeywords[$item] = $query->take(25)->get();
        }

        return $includedsByKeywords;
    }

    public function scopeGetKeywordByNum($query, $uuid, int $num)
    {
        $query->where('uuid', $uuid);
        $query->where('num', (int)$num);
        return $query;
    }
}
