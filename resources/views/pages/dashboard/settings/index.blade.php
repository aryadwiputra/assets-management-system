@extends('layouts.dashboard')

@section('title', 'Pengaturan')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('settings.store') }}" method="POST">
                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company_name">Nama Perusahaan</label>
                            <input type="text" name="company_name" class="form-control" id="company_name"
                                placeholder="Masukkan Nama Perusahaan" value="{{ $settings['company_name'] ?? '' }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company_description">Deskripsi Perusahaan</label>
                            <textarea name="company_description" class="form-control" id="company_description" cols="2" rows="2">{{ $settings['company_description'] ?? '' }}</textarea>
                            @error('company_description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="set_prefix_asset">Prefiks Penomoran Aset?</label>
                            {{-- active or inactive --}}
                            <select name="set_prefix_asset" class="form-control" id="set_prefix_asset">
                                <option value="1" {{ $settings['set_prefix_asset'] == 1 ? 'selected' : '' }}>Ya
                                </option>
                                <option value="0" {{ $settings['set_prefix_asset'] == 0 ? 'selected' : '' }}>Tidak
                                </option>
                            </select>
                            @error('set_prefix_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prefix_asset">Prefiks Penomoran Aset</label>
                            <input type="text" name="prefix_asset" class="form-control" id="prefix_asset"
                                placeholder="Masukkan Prefiks Penomoran Aset" value="{{ $settings['prefix_asset'] ?? '' }}">
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
                                <option value="1" {{ $settings['set_prefix_document_asset'] == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0" {{ $settings['set_prefix_document_asset'] == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                            @error('set_prefix_document_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prefix_document_asset">Prefiks Penomoran Dokumen Aset</label>
                            <input type="text" name="prefix_document_asset" class="form-control"
                                id="prefix_document_asset" placeholder="Masukkan Prefiks Penomoran Aset"
                                value="{{ old('prefix_document_asset') }}">
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
                                <option value="1" {{ $settings['set_prefix_mutation_asset'] == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0" {{ $settings['set_prefix_mutation_asset'] == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                            @error('set_prefix_mutation_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prefix_mutation_asset">Prefiks Penomoran Mutasi Aset</label>
                            <input type="text" name="prefix_mutation_asset" class="form-control"
                                id="prefix_mutation_asset" placeholder="Masukkan Prefiks Penomoran Aset"
                                value="{{ $settings['prefix_mutation_asset'] ?? '' }}">
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
                                <option value="1" {{ $settings['set_prefix_disposal_asset'] == 1 ? 'selected' : '' }}>
                                    Ya</option>
                                <option value="0" {{ $settings['set_prefix_disposal_asset'] == 0 ? 'selected' : '' }}>
                                    Tidak</option>
                            </select>
                            @error('set_prefix_disposal_asset')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="prefix_disposal_asset">Prefiks Penomoran Disposal Aset</label>
                            <input type="text" name="prefix_disposal_asset" class="form-control"
                                id="prefix_disposal_asset" placeholder="Masukkan Prefiks Penomoran Aset"
                                value="{{ $settings['prefix_disposal_asset'] ?? '' }}">
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
                            <label for="favicon">Favicon</label>
                            <input type="file" name="favicon" class="form-control" id="favicon">
                            @error('favicon')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            {{-- Show image if exists --}}
                            {{-- @if ($settings['favicon'])
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['favicon']) }}" alt="Favicon"
                                        class="img-fluid">
                                </div>
                            @endif --}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
