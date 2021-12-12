<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lexique extends Model
{
    use HasFactory;

    protected $table = 'lexiques';

    protected $fillable = [
        'forme',
        'lemme',
        'phon',
        'cat_gram',
        'genre',
        'nombre',
        'freq1',
        'freq2',
        'nb_leters',
        'nb_phons',
        'nb_syllables',
        'cv_cv',
        'def_lem',
    ];
}
