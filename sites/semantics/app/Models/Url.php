<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Url extends Model
{
    use HasFactory;
    use \Awobaz\Compoships\Compoships;

    protected $table = 'urls';

    protected $fillable = [
        'uuid',
        'url',
        'title',
        'content',
        'doc_id'
    ];

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

    public function scopeGetStudyUrls($query, $uuid)
    {
        $query->where('uuid', $uuid);
        return $this->query;
    }

    public function scopeGetUrl($query, $uuid, $docId)
    {
        $query->where('uuid', $uuid);
        $query->where('doc_id', $docId);
        return $query;
    }
}
