<?php

namespace App\Http\Controllers;



use App\Exports\AuditListExport;
use App\Exports\RtListeExport;
use App\Exports\UrlExport;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function AuditList($uuid)
    {
        return Excel::download(new AuditListExport($uuid), 'descripteurs.csv');
    }

    public function RtList($uuid)
    {
        return Excel::download(new RtListeExport($uuid), 'keywords.csv');
    }

    public function urls($uuid)
    {
        return Excel::download(new UrlExport($uuid), 'urls.csv');
    }

}