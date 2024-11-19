@extends('layouts.dashboard')

@section('title', 'Detail Mutasi')

@push('style')
    @include('style.datatable')
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center">
                <h3 class="card-title">
                    Detail Mutasi
                </h3>
                <a href="{{ route('dashboard.mutations.print', $mutation->id) }}" class="btn btn-primary ml-auto">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="{{ route('dashboard.mutations.edit', $mutation) }}" class="btn btn-success ml-2">
                    <i class="fas fa-pencil-alt"></i>
                </a>
                {{-- If else status mutation open or close --}}
                @if ($mutation->status == 'open')
                    <form action="{{ route('dashboard.mutations.cancel', $mutation->id) }}" method="post"
                        id="form-cancel-mutation">
                        @csrf
                        <button class="btn btn-danger ml-2" type="button" id="button-cancel-mutation">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                @elseif($mutation->status == 'cancel')
                    <form action="{{ route('dashboard.mutations.open', $mutation->id) }}" method="post"
                        id="form-open-mutation">
                        @csrf
                        <button class="btn btn-primary ml-2" type="button" id="button-open-mutation">
                            <i class="fas fa-check"></i>
                        </button>
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Nama Dokumen</th>
                                <td>{{ $mutation->name }}</td>
                            </tr>
                            <tr>
                                <th>Lokasi Tujuan</th>
                                <td>{{ $mutation->location->name }}</td>
                            </tr>
                            <tr>
                                <th>Proyek</th>
                                <td>{{ $mutation->project->name }}</td>
                            </tr>
                            <tr>
                                <th>Penanggung Jawab</th>
                                <td>{{ $mutation->pic->name }}</td>
                            </tr>
                            <tr>
                                <th>Deskripsi</th>
                                <td>{{ $mutation->description }}</td>
                            </tr>
                            <tr>
                                <th>Komentar</th>
                                <td>{{ $mutation->comment }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ strtoupper($mutation->status) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($mutation->status != 'done')
                    <div class="col-md-12">
                        <form action="{{ route('dashboard.mutations.done', $mutation->id) }}" method="post"
                            id="form-done-mutation">
                            @csrf
                            <button type="submit" class="btn btn-success" id="button-done-mutation">Selesai</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card card-tabs">
        <div class="card-header p-0 pt-1">
            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill"
                        href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                        aria-selected="false">Add Assets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home"
                        role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Detail Assets</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill"
                        href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages"
                        aria-selected="false">Upload Document</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill"
                        href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings"
                        aria-selected="false">Settings</a>
                </li> --}}
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="custom-tabs-one-tabContent">
                <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel"
                    aria-labelledby="custom-tabs-one-profile-tab">
                    <div class="mb-3">
                        <form action="{{ route('dashboard.mutations.bulk-add-asset') }}" method="post" id="bulk-add-form">
                            @csrf
                            <input type="hidden" name="mutation_id" value="{{ $mutation->id }}">
                            <button type="submit" class="btn btn-primary" id="bulk-add-button">
                                <i class="fas fa-plus"></i> Bulk Add
                            </button>
                        </form>
                    </div>
                    <table class="table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all"></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($available_assets as $data)
                                <tr>
                                    <td><input type="checkbox" class="asset-checkbox" value="{{ $data->id }}"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->description }}</td>
                                    <td>
                                        {{-- Button to add data with icon --}}
                                        <form action="{{ route('dashboard.mutations.add-asset') }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            <input type="hidden" name="mutation_id" value="{{ $mutation->id }}">
                                            <input type="hidden" name="asset_id" value="{{ $data->id }}">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-home" role="tabpanel"
                    aria-labelledby="custom-tabs-one-home-tab">
                    <div class="mb-3">
                        <form action="{{ route('dashboard.mutations.bulk-remove-asset') }}" method="post"
                            id="bulk-delete-asset-form">
                            @csrf
                            <input type="hidden" name="mutation_id" value="{{ $mutation->id }}">
                            <button type="button" class="btn btn-danger" id="bulk-delete-asset-button">
                                <i class="fas fa-trash"></i> Bulk Delete
                            </button>
                        </form>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select-all-delete"></th>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mutation->assets as $item)
                                <tr>
                                    <td><input type="checkbox" class="asset-checkbox-delete"
                                            value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->slug }}</td>
                                    <td>
                                        {{-- Button to remove data with icon --}}
                                        <form action="{{ route('dashboard.mutations.remove-asset') }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="mutation_id" value="{{ $mutation->id }}">
                                            <input type="hidden" name="asset_id" value="{{ $item->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel"
                    aria-labelledby="custom-tabs-one-messages-tab">
                    Morbi turpis dolor, vulputate vitae felis non, tincidunt congue mauris. Phasellus volutpat augue id mi
                    placerat mollis. Vivamus faucibus eu massa eget condimentum. Fusce nec hendrerit sem, ac tristique
                    nulla. Integer vestibulum orci odio. Cras nec augue ipsum. Suspendisse ut velit condimentum, mattis urna
                    a, malesuada nunc. Curabitur eleifend facilisis velit finibus tristique. Nam vulputate, eros non luctus
                    efficitur, ipsum odio volutpat massa, sit amet sollicitudin est libero sed ipsum. Nulla lacinia, ex
                    vitae gravida fermentum, lectus ipsum gravida arcu, id fermentum metus arcu vel metus. Curabitur eget
                    sem eu risus tincidunt eleifend ac ornare magna.
                </div>
                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel"
                    aria-labelledby="custom-tabs-one-settings-tab">
                    Pellentesque vestibulum commodo nibh nec blandit. Maecenas neque magna, iaculis tempus turpis ac, ornare
                    sodales tellus. Mauris eget blandit dolor. Quisque tincidunt venenatis vulputate. Morbi euismod molestie
                    tristique. Vestibulum consectetur dolor a vestibulum pharetra. Donec interdum placerat urna nec
                    pharetra. Etiam eget dapibus orci, eget aliquet urna. Nunc at consequat diam. Nunc et felis ut nisl
                    commodo dignissim. In hac habitasse platea dictumst. Praesent imperdiet accumsan ex sit amet facilisis.
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
@endsection


@push('script')
    @include('scripts.datatable')

    <script>
        $(function() {
            let table = $("#data-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                // "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');

            let tableDetail = $("#table-detail").DataTable({
                "responsive": true,
                "lengthChange": false,
                // "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#table-detail_wrapper .col-md-6:eq(0)');

            $('#bulk-add-button').on('click', function(e) {
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
                    $('#bulk-add-form').append(
                        '<input type="hidden" name="asset_ids[]" value="' + assetId + '">');
                });

                $('#bulk-add-form').submit();
            });

            // Handle bulk delete asset
            $('#bulk-delete-asset-button').on('click', function(e) {
                e.preventDefault();
                let assetIds = [];
                $('.asset-checkbox-delete:checked').each(function() {
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
                        // Append asset IDs as array
                        assetIds.forEach(function(assetId) {
                            $('#bulk-delete-asset-form').append(
                                '<input type="hidden" name="asset_ids[]" value="' +
                                assetId + '">');
                        });

                        console.log(assetIds)

                        $('#bulk-delete-asset-form').submit();
                    }
                });
            });

            // Select all checkboxes
            $('#select-all').on('click', function() {
                $('.asset-checkbox').prop('checked', $(this).is(':checked'));
            });

            // Select all checkboxes
            $('#select-all-delete').on('click', function() {
                $('.asset-checkbox-delete').prop('checked', $(this).is(':checked'));
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

            $('#button-cancel-mutation').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dibatalkan tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Batalkan!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-cancel-mutation').submit();
                    }
                })
            })

            // Handle open mutation
            $('#button-open-mutation').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dibuka tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Buka!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-open-mutation').submit();
                    }
                })
            })

            // Handle done mutation
            $('#button-done-mutation').on('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang selesai tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Selesai!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#form-done-mutation').submit();
                    }
                })
            })
        });
    </script>
@endpush
