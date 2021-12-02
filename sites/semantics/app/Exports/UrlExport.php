<?php


namespace App\Exports;

use App\Models\SyntexAuditDesc;
use App\Models\SyntexDescripteur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UrlExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function collection()
    {
        $res = SyntexDescripteur::with('url')
            ->where('uuid', $this->uuid)
            ->orderBy('doc_id', 'ASC')
            ->orderBy('rang', 'ASC')
            ->get()
            ;

        return $res;
    }

    public function headings(): array
    {
        return [
            'doc',
            'doc_id',
            'title',
            'Keyword',
            'Length',
            'Score',
            'Score_moy',
            'frequence_doc'
        ];
    }

    public function map($auditDesc): array
    {
        return [
            $auditDesc->url->url,
            $auditDesc->url->title,
            $auditDesc->doc_id,
            $auditDesc->forme,
            $auditDesc->longueur,
            $auditDesc->score,
            $auditDesc->score_moy,
            $auditDesc->freq_doc,
        ];
    }
}