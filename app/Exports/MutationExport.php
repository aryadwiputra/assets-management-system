<?php
namespace App\Exports;

use App\Models\Mutation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MutationExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        return Mutation::whereBetween('created_at', [$this->start_date, $this->end_date])
            ->with('assets', 'location', 'user', 'pic')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Mutasi',
            'Nama Mutasi',
            'Tanggal Mutasi',
            'Lokasi Awal',
            'Lokasi Akhir',
            'Pengguna',
            'PIC',
            'Deskripsi',
            'Komentar',
            'Status',
        ];
    }
}