<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Url extends Model
{
    use HasFactory;

    protected $collection = 'urls';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    // protected $fillable = [
    //     'uuid',
    //     'url',
    //     'title',
    //     'content',
    // ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::where('uuid', $data['uuid'])->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    public static function insert($data)
    {
        try  {
            return Self::insertGetId($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
