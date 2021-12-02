<?php


namespace App\Exports;

use App\Models\SyntexAuditListe;
use App\Models\SyntexDescripteur;
use App\Models\SyntexRtListe;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RtListeExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function query()
    {
        return SyntexRtListe::query()
        ->select('forme', 'lemme', 'category_name', 'longueur', 'freq', 'nb_doc')
        ->where('uuid', $this->uuid)
        ->orderBy('freq', 'DESC')
        ;
    }

    public function headings(): array
    {
        return [
            'Keyword',
            'Lemme',
            'Category',
            'Length',
            'frequence',
            'nbDocs'
        ];
    }
}