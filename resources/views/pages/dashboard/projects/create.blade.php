@extends('layouts.dashboard')

@section('title', 'Tambah Data Proyek')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.projects.store') }}" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    @csrf

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="company_id">Perusahaan</label>
                            <select name="company_id" class="form-control" id="company_id">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            @error('company_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Proyek</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Proyek" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" placeholder="Deskripsi Proyek" class="form-control" id="description" cols="2"
                                rows="2">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea name="address" placeholder="Alamat Proyek" class="form-control" id="address" cols="2" rows="2">{{ old('address') }}</textarea>
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="is_active">Aktif?</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1">Ya</option>
                                <option value="0">Tidak</option>
                            </select>
                            @error('is_active')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
