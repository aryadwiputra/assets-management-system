@extends('layouts.dashboard')

@section('title', 'Edit Data Kelas Aset')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.class.update', $asset->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    @method('PUT')
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Kelas Aset" value="{{ $asset->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" placeholder="Masukkan Deskripsi Kelas Aset" class="form-control" id="description"
                                cols="2" rows="2">{{ $asset->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from">Dari</label>
                            <input type="number" name="from" class="form-control" placeholder="Masukkan Harga Dari"
                                value="{{ $asset->from }}" id="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to">Sampai</label>
                            <input type="number" name="to" class="form-control" placeholder="Masukkan Harga Sampai"
                                value="{{ $asset->to }}" id="">
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
