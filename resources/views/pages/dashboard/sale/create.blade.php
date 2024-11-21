@extends('layouts.dashboard')

@section('title', 'Tambah Disposal Aset')

@push('style')
    @include('style.select2')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.sales.store') }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project_id">Proyek <span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="project_id" class="form-control select2" id="project_id">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pic_id">PIC <span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="pic_id" class="form-control select2" id="pic_id">
                                @foreach ($person_in_charges as $person_in_charge)
                                    <option value="{{ $person_in_charge->id }}">{{ $person_in_charge->name }}</option>
                                @endforeach
                            </select>
                            @error('pic_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" id="status">
                                <option value="open">Open</option>
                                <option value="done">Done</option>
                                <option value="cancel">Cancel</option>

                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Tanggal<span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control" id="date"
                                placeholder="Masukkan Tanggal Disposal Aset" value="{{ old('date') }}">
                            @error('date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama Dokumen<span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Dokumen Penjualan Aset" value="{{ old('name') }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="buyer_name">Nama Pembeli<span class="text-danger">*</span></label>
                            <input type="text" name="buyer_name" class="form-control" id="buyer_name"
                                placeholder="Masukkan Nama Pembeli Aset" value="{{ old('buyer_name') }}">
                            @error('buyer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="buyer_contact">Kontak Pembeli<span class="text-danger">*</span></label>
                            <input type="text" name="buyer_contact" class="form-control" id="buyer_contact"
                                placeholder="Masukkan Kontak Pembeli Aset" value="{{ old('buyer_contact') }}">
                            @error('buyer_contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="price">Total Harga<span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" id="price"
                                placeholder="Masukkan Total Penjualan Aset" value="{{ old('price') }}">
                            @error('price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea name="notes" placeholder="Masukkan Catatan Disposal Aset" class="form-control" id="notes" cols="2"
                                rows="2">{{ old('notes') }}</textarea>
                            @error('notes')
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
