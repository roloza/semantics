<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
// use Jenssegers\Mongodb\Eloquent\Model;
// use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // use HybridRelations;

    protected $table = 'jobs';
    // protected $collection = 'jobs';
    // protected $connection = 'mongodb';
    // protected $primaryKey = 'uuid';

    public $timestamps = true;

    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'type_id',
        'status_id',
        'percentage',
        'message',
    ];

    protected $with = [
        'parameters',
        'failedJob',
        'type',
        'user',
        'status'
    ];

    public function parameters()
    {
        return $this->belongsToMany(Parameters::class, 'job_parameter', 'job_id', 'parameter_id');
    }

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

    public static function hasJob($params, $userId, $typeId)
    {
        $query = self::query();
        $query->where('user_id', $userId);
        $query->where('type_id', $typeId);

        $jobs = $query->get();

        foreach($jobs as $job) {
            $sameJob = true;
            foreach($job->parameters as $parameter) {
                if (!isset($params[$parameter->name])) continue;
                if ($params[$parameter->name] != $parameter->value) {
                    $sameJob = false;
                }
            }
            if ($sameJob) {
                return $job;
            }
        }
        return false;
    }
}
