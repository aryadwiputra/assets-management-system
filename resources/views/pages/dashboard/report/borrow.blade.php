@extends('layouts.dashboard')

@section('title', 'Laporan Peminjaman Aset')

@push('style')
    @include('style.datatable')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- Filter berdasarkan tanggal from dan to --}}
            <form action="{{ route('dashboard.report.printBorrow') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_date">Tanggal Dari</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ old('start_date') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_date">Tanggal Sampai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-print"></i> Cetak Laporan (Excel)
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    @include('scripts.datatable')

    <script>
        $(function() {
            let table = $("#data-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
