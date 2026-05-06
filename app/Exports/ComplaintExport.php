<?php

namespace App\Exports;

use App\Models\Complaint;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComplaintExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
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
        $query = Complaint::with(['user']);

        if (!empty($this->filters['status']) && $this->filters['status'] != 'semua') {
            $query->where('status', ucfirst($this->filters['status']));
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        if ($this->role == 'admin') {
            $query->whereIn('status', ['Diproses', 'Ditolak', 'Selesai']);
        }

        // Apply FIFO ordering
        return $query->orderBy('created_at', 'asc');
    }

    public function map($complaint): array
    {
        return [
            $complaint->code,
            date('d-m-Y H:i', strtotime($complaint->created_at)),
            $complaint->user->name,
            $complaint->title,
            $complaint->location,
            $complaint->status,
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor Pengaduan',
            'Tanggal & Waktu',
            'Pelapor',
            'Judul',
            'Lokasi',
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
