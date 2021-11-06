<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyntexAuditDesc extends Model
{
    use HasFactory;

    protected $collection = 'syntex_audit_descs';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'job_id',
        'doc_id',
        'num',
        'score',
        'score_moy',
        'freq_doc',
        'forme',
        'longueur'
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('doc_id', $data['doc_id'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexAuditDesc] - ' .$e->getMessage());
        }
    }
}
