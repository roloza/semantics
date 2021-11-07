<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\HybridRelations;


class Job extends Model
{
    use HybridRelations;

    protected $collection = 'jobs';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'type_id',
        'status_id',
        'percentage',
        'message',
        'params',
    ];

    protected $with = [
        'failedJob',
        'type',
        'user',
        'status'
    ];

    public function failedJob()
    {
        return $this->hasOne(FailedJob::class, 'uuid', 'uuid');
    }

    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public static function insertUpdate($data)
    {
        try  {
            Self::where('uuid', $data['uuid'])->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
