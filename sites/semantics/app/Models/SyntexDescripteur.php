<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexDescripteur extends Model
{
    use HasFactory;

    protected $table = 'syntex_descripteurs';

    protected $fillable = [
        'job_id',
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

}
