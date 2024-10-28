@extends('layouts.dashboard')

@section('title', 'Tambah Data Perusahaan')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.companies.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Perusahaan</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Perusahaan" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi Perusahaan</label>
                            <textarea name="description" class="form-control" id="description" cols="2" rows="2">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="set_prefix_asset">Prefiks Penomoran Aset?</label>
                            {{-- active or inactive --}}
                            <select name="set_prefix_asset" class="form-control" id="set_prefix_asset">
                                <option value="1">Ya
                                </option>
                                <option value="0">Tidak
                                </option>
                            </select>
                            @error('set_prefix_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="prefix_asset">
                        <div class="form-group">
                            <label for="prefix_asset">Prefiks Penomoran Aset</label>
                            <input type="text" name="prefix_asset" class="form-control"
                                placeholder="Masukkan Prefiks Penomoran Aset">
                            @error('prefix_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="set_prefix_document_asset">Prefiks Penomoran Dokumen Aset?</label>
                            {{-- active or inactive --}}
                            <select name="set_prefix_document_asset" class="form-control" id="set_prefix_document_asset">
                                <option value="1">
                                    Ya</option>
                                <option value="0">
                                    Tidak</option>
                            </select>
                            @error('set_prefix_document_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="prefix_document_asset">
                        <div class="form-group">
                            <label for="prefix_document_asset">Prefiks Penomoran Dokumen Aset</label>
                            <input type="text" name="prefix_document_asset" class="form-control"
                                placeholder="Masukkan Prefiks Penomoran Aset" value="{{ old('prefix_document_asset') }}">
                            @error('prefix_document_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="set_prefix_mutation_asset">Prefiks Penomoran Mutasi Aset?</label>
                            {{-- active or inactive --}}
                            <select name="set_prefix_mutation_asset" class="form-control" id="set_prefix_mutation_asset">
                                <option value="1">
                                    Ya</option>
                                <option value="0">
                                    Tidak</option>
                            </select>
                            @error('set_prefix_mutation_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="prefix_mutation_asset">
                        <div class="form-group">
                            <label for="prefix_mutation_asset">Prefiks Penomoran Mutasi Aset</label>
                            <input type="text" name="prefix_mutation_asset" class="form-control"
                                placeholder="Masukkan Prefiks Penomoran Aset" value="{{ old('prefix_mutation_asset') }}">
                            @error('prefix_mutation_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="set_prefix_disposal_asset">Prefiks Penomoran Disposal Aset?</label>
                            {{-- active or inactive --}}
                            <select name="set_prefix_disposal_asset" class="form-control" id="set_prefix_disposal_asset">
                                <option value="1">
                                    Ya</option>
                                <option value="0">
                                    Tidak</option>
                            </select>
                            @error('set_prefix_disposal_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12" id="prefix_disposal_asset">
                        <div class="form-group">
                            <label for="prefix_disposal_asset">Prefiks Penomoran Disposal Aset</label>
                            <input type="text" name="prefix_disposal_asset" class="form-control"
                                placeholder="Masukkan Prefiks Penomoran Aset" value="{{ old('prefix_disposal_asset') }}">
                            @error('prefix_disposal_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="file" name="logo" class="form-control" id="logo">
                            @error('logo')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- Show image if exists --}}
                            {{-- @if ($settings['logo'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo"
                                        class="img-fluid">
                                </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            // Fungsi untuk menunjukkan atau menyembunyikan prefix input
            function togglePrefix(selector, target) {
                if ($(selector).val() == 1) {
                    $(target).show();
                } else {
                    $(target).hide();
                }
            }

            // Panggil fungsi toggle saat halaman pertama kali dimuat
            togglePrefix('#set_prefix_asset', '#prefix_asset');
            togglePrefix('#set_prefix_document_asset', '#prefix_document_asset');
            togglePrefix('#set_prefix_mutation_asset', '#prefix_mutation_asset');
            togglePrefix('#set_prefix_disposal_asset', '#prefix_disposal_asset');

            // Tambahkan event listener untuk setiap select
            $('#set_prefix_asset').on('change', function() {
                togglePrefix(this, '#prefix_asset');
            });
            $('#set_prefix_document_asset').on('change', function() {
                togglePrefix(this, '#prefix_document_asset');
            });
            $('#set_prefix_mutation_asset').on('change', function() {
                togglePrefix(this, '#prefix_mutation_asset');
            });
            $('#set_prefix_disposal_asset').on('change', function() {
                togglePrefix(this, '#prefix_disposal_asset');
            });
        });
    </script>
@endpush
