<?php

namespace App\Exports;

use App\Models\RequestLetter;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RequestExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $filters;
    protected $role;

    public function __construct(array $filters, $role)
    {
        $this->filters = $filters;
        $this->role = $role;
    }

    public function query()
    {
        $query = RequestLetter::with(['user', 'requestType']);

        if (!empty($this->filters['status']) && $this->filters['status'] != 'semua') {
            $query->where('status', ucfirst($this->filters['status']));
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['request_type_id'])) {
            $query->where('request_type_id', $this->filters['request_type_id']);
        }

        // Apply FIFO ordering (same as the datatables view)
        return $query->orderBy('created_at', 'asc');
    }

    public function map($requestLetter): array
    {
        return [
            $requestLetter->code,
            $requestLetter->document_number ?? '-',
            date('d-m-Y', strtotime($requestLetter->created_at)),
            $requestLetter->requestType->name,
            $requestLetter->user->name,
            $requestLetter->status,
        ];
    }

    public function headings(): array
    {
        return [
            'No. Request',
            'No. Dokumen',
            'Tgl. Pengajuan',
            'Jenis Pengajuan',
            'Pemohon',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
