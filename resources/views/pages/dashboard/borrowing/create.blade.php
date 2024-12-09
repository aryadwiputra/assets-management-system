@extends('layouts.dashboard')

@section('title', 'Tambah Mutasi Aset')

@push('style')
    @include('style.select2')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.assets.borrow.store') }}" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="asset_id">Pilih Aset</label>
                            <select id="asset_id" name="asset_id" class="form-control select2">
                                @foreach ($assets as $asset)
                                    <option value="{{ $asset->id }}">{{ $asset->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="employee_id">Peminjam <span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="employee_id" class="form-control select2" id="employee_id">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="status">
                                <option value="pending">Pending</option>
                                <option value="accept">Disetujui</option>
                                <option value="late">Terlambat</option>
                                <option value="reject">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="from_date">Dari Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="from_date" class="form-control" id="from_date"
                                placeholder="Masukkan Dari Tanggal" value="{{ old('from_date') }}">
                            @error('from_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_date">Sampai Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="to_date" class="form-control" id="to_date"
                                placeholder="Masukkan Sampai Tanggal" value="{{ old('to_date') }}">
                            @error('to_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" placeholder="Masukkan Deskripsi  Mutasi Aset" class="form-control" id="description"
                                cols="2" rows="2">{{ old('description') }}</textarea>
                            @error('description')
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


@push('script')
    @include('scripts.select2')

    <script>
        $(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });
        });
    </script>
@endpush
