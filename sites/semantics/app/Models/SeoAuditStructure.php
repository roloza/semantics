<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class SeoAuditStructure extends Model
{

    use HasFactory;

    protected $table = 'audit_seo';

    protected $fillable = [
        'uuid',
        'url_id',
        'structure',
    ];

    protected $casts = [
        'structure' => 'array'
    ];
}
