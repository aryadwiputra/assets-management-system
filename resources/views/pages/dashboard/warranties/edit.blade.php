@extends('layouts.dashboard')

@section('title', 'Edit Data Garansi')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.warranties.update', $warranty->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Garansi" value="{{ $warranty->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="period">Periode</label>
                            <div class="input-group mb-3">
                                <input type="number" name="period" class="form-control" placeholder="Masukkan Periode"
                                    value="{{ $warranty->period }}">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Hari</span>
                                </div>
                            </div>
                            {{-- <input type="number" name="period" class="form-control" id="period"
                                placeholder="Masukkan Periode Garansi" value="{{ old('period') }}"> --}}
                            @error('period')
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
