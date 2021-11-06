<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
use Jenssegers\Mongodb\Eloquent\Model;



class SeoAuditStructure extends Model
{

    protected $collection = 'seo_audit_structure';
    protected $connection = 'mongodb';

    protected $primaryKey = 'uuid';

    public static function insertUpdate($data)
    {
        try  {
            Self::where('url_id', $data['url_id'])->update($data, ['upsert' => true]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}
