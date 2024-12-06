@extends('layouts.dashboard')

@section('title', 'Data Aset')

@push('style')
    @include('style.datatable')
@endpush

@section('content')

    <div class="content-header">
        <div class="d-flex justify-content-between">
            <h5>Data</h5>
            <div class="d-flex justify-content-between mb-2">
                <button class="btn btn-secondary mx-2" id="bulk-mutation" disabled data-toggle="modal"
                    data-target="#mutationModal">
                    <i class="nav-icon fas fa-arrows-alt"></i>
                    Bulk Mutasi
                </button>
                {{-- Modal --}}
                <div class="modal fade" id="mutationModal" tabindex="-1" role="dialog" aria-labelledby="mutationModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mutationModalLabel">Bulk Mutasi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="bulk-add-mutation-form" action="{{ route('dashboard.mutations.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        {{-- To Location --}}
                                        <label for="to_location">To Location</label>
                                        <select class="form-control select2" id="to_location" name="to_location">
                                            @foreach ($locations as $location)
                                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        {{-- PIC --}}
                                        <label for="pic">PIC</label>
                                        <select class="form-control select2" id="pic" name="to_pic">
                                            @foreach ($pics as $person_in_charge)
                                                <option value="{{ $person_in_charge->id }}">{{ $person_in_charge->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        {{-- Employee --}}
                                        <label for="employee">Pengguna</label>
                                        <select class="form-control select2" id="employee" name="to_employee">
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success mx-2" data-toggle="modal" data-target="#importModal">
                    <i class="fas fa-file-import"></i> Import Data
                </button>
                {{-- Modal --}}
                <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('dashboard.assets.import') }}" method="POST"
                                enctype="multipart/form-data">
                                <div class="modal-body">
                                    @csrf
                                    <div class="form-group">
                                        <label for="file">File Excel</label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Import</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-info mx-2" id="print-qr-btn">
                    <i class="fas fa-print"></i> Print QR
                </button>
                <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">
                    Tambah Aset
                </a>
            </div>
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
                        <th><input type="checkbox" id="select-all"></th>
                        <th>No</th>
                        <th>QR</th>
                        <th>Thumbnail</th>
                        <th>Lokasi</th>
                        <th>Kategori</th>
                        <th>Nomor ERP</th>
                        <th>Nomor Aset</th>
                        <th>Nama</th>
                        <th>PIC</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $data)
                        <tr>
                            <td><input type="checkbox" class="asset-checkbox" value="{{ $data->id }}"></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{-- Show QR --}}
                                <img src="{{ asset('storage/asset/qr/' . $data->slug . '.png') }}" alt="qr"
                                    class="img-fluid" width="100">
                            </td>
                            <td>
                                @if ($data->thumbnail)
                                    <img src="{{ Storage::url($data->thumbnail) }}" alt="thumbnail" class="img-fluid"
                                        width="150">
                                @endif
                            </td>
                            <td>{{ $data->location->name }}</td>
                            <td>{{ $data->category->name }}</td>
                            <td>{{ $data->erp_number }}</td>
                            <td>{{ $data->number }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->person_in_charge->name }}</td>
                            <td>
                                <a href="{{ route('dashboard.assets.show', $data->id) }}" class="btn btn-success">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('dashboard.assets.edit', $data->id) }}" class="btn btn-primary btn">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('dashboard.assets.destroy', $data->id) }}" method="post"
                                    class="delete-form d-inline">
                                    @csrf

                                    @method('delete')
                                    <button type="button" class="btn btn-danger btn-delete-data">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
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
                "lengthChange": true,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ]
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

            // Print QR button
            $('#print-qr-btn').on('click', function() {
                let selectedIds = [];
                $('.asset-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                if (selectedIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak ada QR yang dipilih',
                        text: 'Silakan pilih QR yang ingin Anda cetak.'
                    });
                    return;
                }

                window.location.href = "{{ route('dashboard.assets.print-qr') }}?ids=" + selectedIds.join(
                    ',');
            });
        });
    </script>

    {{-- Script Bulk Mutation --}}
    <script>
        $(document).ready(function() {
            // Fungsi untuk memeriksa apakah ada aset yang dipilih
            function checkAssetSelection() {
                let assetIds = [];
                $('.asset-checkbox:checked').each(function() {
                    assetIds.push($(this).val());
                });

                // Aktifkan atau nonaktifkan tombol berdasarkan jumlah aset yang dipilih
                if (assetIds.length > 0) {
                    $('#bulk-mutation').prop('disabled', false);
                } else {
                    $('#bulk-mutation').prop('disabled', true);
                }
            }

            // Event listener untuk checkbox "Select All"
            $('#select-all').on('change', function() {
                $('.asset-checkbox').prop('checked', $(this).is(':checked'));
                checkAssetSelection();
            });

            // Event listener untuk checkbox aset
            $('.asset-checkbox').on('change', function() {
                checkAssetSelection();
            });

            // Event listener untuk tombol Bulk Mutasi
            $('#bulk-mutation').on('click', function(e) {
                e.preventDefault();
                let assetIds = [];
                $('.asset-checkbox:checked').each(function() {
                    assetIds.push($(this).val());
                });

                if (assetIds.length === 0) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Tidak ada aset yang dipilih.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Append asset IDs as array
                assetIds.forEach(function(assetId) {
                    $('#bulk-add-mutation-form').append(
                        '<input type="hidden" name="asset_ids[]" value="' + assetId + '">');
                });

                // Show modal
                $('#mutationModal').modal('show');
            });
        });
    </script>
@endpush
