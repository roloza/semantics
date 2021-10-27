<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexAuditListe extends Model
{
    use HasFactory;

    protected $table = 'syntex_audit_listes';

    protected $fillable = [
        'job_id',
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
}
