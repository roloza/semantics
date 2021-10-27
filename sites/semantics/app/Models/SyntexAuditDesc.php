<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexAuditDesc extends Model
{
    use HasFactory;

    protected $table = 'syntex_audit_descs';

    protected $fillable = [
        'job_id',
        'doc_id',
        'num',
        'score',
        'score_moy',
        'freq_doc',
        'forme',
        'longueur'
    ];

}
