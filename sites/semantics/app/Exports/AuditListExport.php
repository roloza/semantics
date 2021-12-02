<?php


namespace App\Exports;

use App\Models\SyntexAuditListe;
use App\Models\SyntexDescripteur;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AuditListExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function query()
    {
        return SyntexAuditListe::query()
        ->select('lemme', 'category_name', 'longueur', 'score')
        ->where('uuid', $this->uuid)
        ->orderBy('score', 'DESC')
        ;
    }

    public function headings(): array
    {
        return [
            'Keyword',
            'Category',
            'Length',
            'Score',
        ];
    }
}