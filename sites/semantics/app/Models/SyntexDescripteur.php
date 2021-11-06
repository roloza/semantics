<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyntexDescripteur extends Model
{
    use HasFactory;


    protected $collection = 'syntex_descripteurs';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'doc_id',
        'score',
        'score_moy',
        'freq',
        'titre',
        'longueur',
        'longueur_num',
        'cat',
        'lemme',
        'forme',
        'rang',
        'freq_pond',
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('doc_id', $data['doc_id'])
                ->where('lemme', $data['lemme'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexDescripteur] - ' .$e->getMessage());
        }
    }

}
