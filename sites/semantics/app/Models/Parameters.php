<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameters extends Model
{
    protected $table = 'parameters';

    protected $fillable = [
        'id',
        'name',
        'value'
    ];

    public function Job()
    {
        return $this->belongsTo(Job::class);
    }
}
