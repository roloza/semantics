<?php


namespace App\Models;

use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use AttachableConcern;

    protected $table = 'tags';

    protected $guarded = [];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}