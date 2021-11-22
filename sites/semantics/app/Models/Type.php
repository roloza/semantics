<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;
    // use HybridRelations;

    protected $table = 'types';
    protected $connection = 'mysql';


    protected $fillable = [
        'name',
        'slug'
    ];
}
