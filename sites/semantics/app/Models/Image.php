<?php


namespace App\Models;

use App\Concerns\AttachableConcern;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Image extends Model
{
    use AttachableConcern;
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['filename', 'slug', 'title'];
}