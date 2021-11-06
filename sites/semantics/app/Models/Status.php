<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    use HybridRelations;

    protected $table = 'statuses';
    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'slug'
    ];
}
