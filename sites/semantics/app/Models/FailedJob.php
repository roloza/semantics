<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FailedJob extends Model
{
    use HasFactory;
    use HybridRelations;

    protected $table = 'failed_jobs';
    protected $connection = 'mysql';
}
