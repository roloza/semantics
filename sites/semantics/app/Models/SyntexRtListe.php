<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexRtListe extends Model
{
    use HasFactory;

    protected $table = 'syntex_rt_listes';

    protected $fillable = [
        'job_id',
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
}
