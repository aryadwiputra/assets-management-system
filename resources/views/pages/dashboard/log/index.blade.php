@extends('layouts.dashboard')

@section('title', 'Log Aktivitas')

@push('style')
    @include('style.datatable')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Aksi</th>
                        <th>Causer</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $data)
                        <tr>
                            <td>{{ $data->causer ? $data->causer->name : 'System' }}</td>
                            <td>{{ ucfirst($data->event) }}</td>
                            <td>{{ $data->causer ? $data->causer->name : 'System' }}</td>
                            <td>{{ $data->description }}</td>
                            <td>{{ $data->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
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
