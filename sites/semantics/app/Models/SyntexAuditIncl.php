<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyntexAuditIncl extends Model
{
    use HasFactory;

    protected $table = 'syntex_audit_incls';

    protected $fillable = [
        'job_id',
        'num_1',
        'numb_2'
    ];

}
