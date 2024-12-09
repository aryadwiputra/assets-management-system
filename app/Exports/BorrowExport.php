<?php

namespace App\Exports;

use App\Models\AssetBorrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class BorrowExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
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
        return AssetBorrowing::whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->with('asset', 'employee', 'user')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'Nama Aset',
            'Tanggal Awal Pinjam',
            'Tanggal Akhir Pinjam',
            'Pengguna',
            'Deskripsi',
            'Status',
        ];
    }

    public function map($borrow): array
    {
        return [
            $borrow->id,
            $borrow->asset->name ?? 'N/A',
            $borrow->from_date,
            $borrow->end_date,
            $borrow->user->name ?? 'N/A',
            $borrow->description,
            $borrow->status,
        ];
    }
}
