<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexDescripteur extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'syntex_descripteurs';

    protected $fillable = [
        'uuid',
        'doc_id',
        'score',
        'score_moy',
        'freq',
        'titre',
        'longueur',
        'longueur_num',
        'cat',
        'lemme',
        'forme',
        'rang',
        'freq_pond',
    ];

    public function url()
    {
        return $this->hasOne(Url::class, ['uuid', 'doc_id'], ['uuid','doc_id']);
    }

    public function SyntexRtListe()
    {
        return $this->hasOne(SyntexRtListe::class, ['uuid', 'lemme'], ['uuid','lemme']);
    }

    public function scopeTableUrlDetail($query, $params)
    {
        if (isset($params['uuid']) && $params['uuid'] !== '') {
            $query->where('uuid', $params['uuid']);
        }
        if (isset($params['doc_id']) && $params['doc_id'] !== '') {
            $query->where('doc_id', $params['doc_id']);
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
        $query->with('SyntexRtListe');
        return $query;
    }

}
