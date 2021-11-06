<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SyntexRtListe extends Model
{
    use HasFactory;

    protected $collection = 'syntex_rt_listes';
    protected $connection = 'mongodb';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'num',
        'cat',
        'lemme',
        'forme',
        'freq',
        'nb_doc',
        'frequisol',
        'nincl',
        'longueur'
    ];

    public static function insertUpdate($data)
    {
        try  {
            return Self::
                where('uuid', $data['uuid'])
                ->where('num', $data['num'])
                ->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error('[SyntexRtListe] - ' .$e->getMessage());
        }
    }
}
