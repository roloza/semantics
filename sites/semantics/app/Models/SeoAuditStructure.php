<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;



class SeoAuditStructure extends Model
{

    protected $collection = 'seo_audit_structure';
    protected $connection = 'mongodb';

    protected $primaryKey = 'uuid';

}
