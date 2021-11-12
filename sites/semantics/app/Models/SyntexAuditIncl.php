<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyntexAuditIncl extends Model
{
    use HasFactory;


    protected $collection = 'syntex_audit_incls';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'num_1',
        'num_2'
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('num_1', $data['num_1'])
                ->where('num_2', $data['num_2'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexAuditIncl] - ' .$e->getMessage());
        }
    }

    public function scopeGetChildNums($query, $uuid, $num)
    {
        $query->where('uuid', $uuid);
        $query->where('num_1', $num);
        $query->where('num_2', '<>', $num);
        return $query;
    }

    public function scopeGetParentNums($query, $uuid, $num)
    {
        $query->where('uuid', $uuid);
        $query->where('num_2', $num);
        $query->where('num_1', '<>', $num);
        return $query;
    }


}
