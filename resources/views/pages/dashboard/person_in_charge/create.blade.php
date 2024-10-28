@extends('layouts.dashboard')

@section('title', 'Tambah Data Person in Charge')

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.person-in-charge.store') }}" method="POST"
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
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Person in Charge" value="{{ old('name') }}">
                            @error('name')
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
