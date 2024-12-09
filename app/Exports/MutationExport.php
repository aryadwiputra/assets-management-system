<?php

namespace App\Exports;

use App\Models\Mutation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MutationExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $start_date;
    protected $end_date;

    public function __construct($start_date, $end_date)
    {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
    }

    public function collection()
    {
        // Menggunakan eager loading untuk memuat relasi yang dibutuhkan
        return Mutation::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->with('asset', 'fromLocation', 'toLocation', 'user', 'fromPic', 'toPic')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Mutasi',
            'Nama Aset',
            'Tanggal Mutasi',
            'Lokasi Awal',
            'Lokasi Akhir',
            'Pengguna',
            'PIC Awal',
            'PIC Akhir',
            'Deskripsi',
            'Status',
        ];
    }

    public function map($mutation): array
    {
        // Memastikan setiap relasi aman untuk diakses dan memiliki fallback
        return [
            $mutation->id,
            $mutation->asset->name ?? 'N/A',
            $mutation->created_at->format('d M Y H:i:s'),
            $mutation->fromLocation->name ?? 'N/A',
            $mutation->toLocation->name ?? 'N/A',
            $mutation->user->name ?? 'N/A',
            $mutation->fromPic->name ?? 'N/A',
            $mutation->toPic->name ?? 'N/A',
            $mutation->description ?? 'N/A',
            $mutation->status ?? 'N/A',
        ];
    }
}
