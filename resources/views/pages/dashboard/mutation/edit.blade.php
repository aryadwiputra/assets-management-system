@extends('layouts.dashboard')

@section('title', 'Tambah Mutasi Aset')

@push('style')
    @include('style.select2')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.mutations.update', $mutation->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="row">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="project_id">Proyek <span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="project_id" class="form-control select2" id="project_id">
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $project->id == $mutation->project_id ? 'selected' : '' }}>{{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('project_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="to_location">Lokasi<span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="to_location" class="form-control select2" id="to_location">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $location->id == $mutation->to_location ? 'selected' : '' }}>
                                        {{ $location->name }}</option>
                                @endforeach
                            </select>
                            @error('to_location')
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
                                    <option value="{{ $person_in_charge->id }}"
                                        {{ $person_in_charge->id == $mutation->pic_id ? 'selected' : '' }}>
                                        {{ $person_in_charge->name }}</option>
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
                                <option value="open" {{ $mutation->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="done" {{ $mutation->status == 'done' ? 'selected' : '' }}>Done</option>
                                <option value="cancel" {{ $mutation->status == 'cancel' ? 'selected' : '' }}>Cancel</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Nama <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama Dokumen Mutasi Aset" value="{{ $mutation->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea name="description" placeholder="Masukkan Deskripsi  Mutasi Aset" class="form-control" id="description"
                                cols="2" rows="2">{{ $mutation->description }}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="comment">Komentar</label>
                            <textarea name="comment" placeholder="Masukkan Komentar Mutasi Aset" class="form-control" id="comment" cols="2"
                                rows="2">{{ $mutation->comment }}</textarea>
                            @error('comment')
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
