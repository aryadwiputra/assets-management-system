@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@push('style')
    @include('style.select2')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" class="form-control" id="name"
                                placeholder="Masukkan Nama" value="{{ $user->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Masukkan Email" value="{{ $user->email }}">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="select2" style="width: 100%;" id="role" name="role">
                                @foreach ($roles as $role)
                                    {{-- selected --}}
                                    <option value="{{ $role->name }}" {{ $role->name == $user->getRoleNames()->first() ? 'selected' : '' }}>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Masukkan Password" value="{{ old('password') }}">
                            <span class="text-muted">
                                <i class="fa fa-info-circle"></i>
                                <small> Kosongkan jika tidak ingin mengganti password</small>
                            </span>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="repeat_password">Repeat Password</label>
                            <input type="password" name="repeat_password" class="form-control" id="repeat_password"
                                placeholder="Masukkan Password" value="{{ old('repeat_password') }}">
                            @error('repeat_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    {{-- Button back and submit --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <a href="{{ route('users.index') }}" id="form-back-button" class="btn btn-default">Kembali</a>
                            <button type="submit" id="form-submit-button" class="btn btn-primary">Simpan</button>
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
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endpush
