@extends('layouts.dashboard')

@section('title', 'Data Mutasi')

@push('style')
    @include('style.datatable')
@endpush

@section('content')

    <div class="content-header">
        <div class="d-flex justify-content-between">
            <h5>Data</h5>
            <div class="d-flex justify-content-between mb-2">
                <a href="{{ route('dashboard.assets.borrow.create') }}" class="btn btn-primary">
                    Tambah Peminjaman
                </a>
            </div>
        </div>
        <a href="#" class="btn d-md-none d-lg-none d-xl-none d-block btn-primary mb-2">
            Tambah Peminjaman
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
                        <th><input type="checkbox" id="select-all"></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Dari Tanggal</th>
                        <th>Sampai Tanggal</th>
                        <th>Peminjam</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($asset_borrow as $data)
                        <tr>
                            <td><input type="checkbox" class="asset-checkbox" value="{{ $data->id }}"></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->asset->name }}</td>
                            <td>{{ $data->from_date }}</td>
                            <td>{{ $data->to_date }}</td>
                            <td>{{ $data->employee->name }}</td>
                            <td>{{ $data->status }}</td>
                            <td>{{ $data->description ?? '-' }}</td>
                            <td>
                                <a href="{{ route('dashboard.assets.borrow.edit', $data->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('dashboard.assets.borrow.destroy', $data->id) }}" method="post"
                                    class="delete-form d-inline">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-danger btn-delete-data">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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