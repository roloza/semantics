<?php

namespace App\Models;

use App\Custom\Tools\StopWords;
use Illuminate\Support\Facades\Log;
// use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexRtListeSuggest extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'syntex_rt_listes_suggest';

    protected $fillable = [
        'suggest',
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

    public function parents()
    {
        return $this->hasMany(SyntexAuditInclSuggest::class, ['num_2', 'suggest'], ['num', 'suggest']);
    }

    public function childs()
    {
        return $this->hasMany(SyntexAuditInclSuggest::class, ['num_1', 'suggest'], ['num', 'suggest']);
    }

}
