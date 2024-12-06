@extends('layouts.dashboard')

@section('title', 'Data Aset')

@push('style')
    @include('style.datatable')
    @include('style.select2')
@endpush

@section('content')

    <div class="content-header">
        <div class="d-flex justify-content-between">
            <h5>Data Mutasi</h5>

        </div>
        <a href="#" class="btn d-md-none d-lg-none d-xl-none d-block btn-primary mb-2">
            Tambah Aset
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>Tanggal Mutasi</th>
                        <th>Lokasi Awal</th>
                        <th>Lokasi Tujuan</th>
                        <th>PIC Awal</th>
                        <th>PIC Tujuan</th>
                        <th>Pengguna Awal</th>
                        <th>Pengguna Tujuan</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mutations as $mutation)
                        <tr>
                            <td>{{ $mutation->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $mutation->fromLocation->name }}</td>
                            <td>{{ $mutation->toLocation->name }}</td>
                            <td>{{ $mutation->fromPic->name }}</td>
                            <td>{{ $mutation->toPic->name }}</td>
                            <td>{{ $mutation->fromEmployee->name }}</td>
                            <td>{{ $mutation->toEmployee->name }}</td>
                            <td>{{ $mutation->status }}</td>
                            <td>{{ $mutation->description ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection


@push('script')
    @include('scripts.datatable')

    @include('scripts.select2')

    <script>
        $(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>

    <script>
        $(function() {
            let table = $("#data-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

            // Select all checkboxes
            $('#select-all').on('click', function() {
                $('.asset-checkbox').prop('checked', $(this).is(':checked'));
            });

            $('.btn-delete-data').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).closest('form').submit();
                    }
                })
            })
        });
    </script>
@endpush
