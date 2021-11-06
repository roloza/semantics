<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyntexAuditListe extends Model
{
    use HasFactory;


    protected $collection = 'syntex_audit_listes';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'num',
        'cat',
        'lemme',
        'longueur_num',
        'score',
        'freq_num',
        'nbincl1_num',
        'nbdoc_num',
        'nbdec_num',
        'longueur_num',
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexAuditListe] - ' .$e->getMessage());
        }
    }
}
