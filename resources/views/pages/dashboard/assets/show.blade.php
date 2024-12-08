@extends('layouts.dashboard')

@section('title', 'Detail Mutasi')

@push('style')
    @include('style.datatable')
@endpush

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Thumbnail</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <img src="{{ asset('storage/' . $asset->thumbnail) }}" alt="" class="img-fluid"
                                    width="300">
                                <div class="mt-3">
                                    <input type="file" class="form-control" id="thumbnail" name="thumbnail">
                                    <button type="button" class="btn btn-primary w-100 mt-2" id="upload-thumbnail">Ubah
                                        Thumbnail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h4>{{ $asset->name }}</h4>
                                <p>{{ $asset->number }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center">
                                <i class="fas fa-map-marker"></i> Lokasi
                            </h5>
                        </div>
                        <div class="card-body">
                            <b class="text-center">{{ $asset->location->name }}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            {{-- If Errors Any --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card card-tabs">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-profile-tab" data-toggle="pill"
                                href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Detail</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-home-tab" data-toggle="pill"
                                href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Pembelian</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-mutation-tab" data-toggle="pill" href="#tabs-mutation"
                                role="tab" aria-controls="tabs-mutation" aria-selected="true">Riwayat Mutasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-disposal-tab" data-toggle="pill" href="#tabs-disposal"
                                role="tab" aria-controls="tabs-disposal" aria-selected="true">Riwayat Disposal</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-repair-cars-tab" data-toggle="pill" href="#tabs-repair-cars"
                                role="tab" aria-controls="tabs-repair-cars" aria-selected="true">Riwayat Perbaikan
                                Mobil</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade active show" id="custom-tabs-one-profile" role="tabpanel"
                            aria-labelledby="custom-tabs-one-profile-tab">

                            <form id="add-data-form" action="{{ route('dashboard.assets.update', $asset->id) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="number">Nomor Aset</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" id="section_assets_number"
                                                    style="display: none">
                                                    <span class="input-group-text" id="assets_number"></span>
                                                </div>
                                                @php
                                                    $number = $asset->number;
                                                    $prefix = preg_replace('/[^0-9]/', '', $number);
                                                @endphp
                                                <input type="number" name="number" class="form-control"
                                                    placeholder="Masukkan Nomor Aset" value="{{ $prefix }}">
                                            </div>
                                            @error('number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="serial_number">Nomor Seri</label>
                                            <input type="text" name="serial_number" class="form-control"
                                                value="{{ $asset->serial_number }}" placeholder="Masukkan Nomor Seri"
                                                id="serial_number">
                                            @error('serial_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Aset<span class="text-danger">*</label>
                                            <input type="text" name="name" class="form-control" id="name"
                                                placeholder="Masukkan Nama Aset" value="{{ $asset->name }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_id">Status Aset<span class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="status_id" class="form-control select2" id="status_id">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->id }}"
                                                        {{ $status->id == $asset->status_id ? 'selected' : '' }}>
                                                        {{ $status->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('status_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Deskripsi<span class="text-danger">*</span></label>
                                            <textarea name="description" placeholder="Masukkan Deskripsi Pengguna Aset" class="form-control" id="description"
                                                cols="2" rows="2">{{ $asset->description }}</textarea>
                                            @error('description')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category_id">Kategori Aset<span
                                                    class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="category_id" class="form-control select2" id="category_id">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_id">Perusahaan <span class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="company_id" class="form-control select2" id="company_id">
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ $company->id == $asset->company_id ? 'selected' : '' }}>
                                                        {{ $company->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('company_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pic_id">Penanggung Jawab<span
                                                    class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="pic_id" class="form-control select2" id="pic_id" disabled>
                                                @foreach ($person_in_charges as $person_in_charge)
                                                    <option value="{{ $person_in_charge->id }}"
                                                        {{ $person_in_charge->id == $asset->pic_id ? 'selected' : '' }}>
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
                                            <label for="employee_id">Pengguna</label>
                                            {{-- Select2 --}}
                                            <select name="employee_id" class="form-control select2" id="employee_id">
                                                <option value="">Tidak ada</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $employee->id == $asset->employee_id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="department_id">Department<span
                                                    class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="department_id" class="form-control select2" id="department_id">
                                                @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}"
                                                        {{ $department->id == $asset->department_id ? 'selected' : '' }}>
                                                        {{ $department->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="class_id">Kelas<span class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="class_id" class="form-control select2" id="class_id">
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ $class->id == $asset->class_id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('class_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="unit_of_measurement_id">Satuan<span
                                                    class="text-danger">*</span></label>
                                            {{-- Select2 --}}
                                            <select name="unit_of_measurement_id" class="form-control select2"
                                                id="unit_of_measurement_id">
                                                @foreach ($unit_of_measurements as $unit_of_measurement)
                                                    <option value="{{ $unit_of_measurement->id }}"
                                                        {{ $unit_of_measurement->id == $asset->unit_of_measurement_id ? 'selected' : '' }}>
                                                        {{ $unit_of_measurement->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit_of_measurement_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="status_information">Keterangan Status</label>
                                            <textarea name="status_information" placeholder="Masukkan Keterangan Status" class="form-control"
                                                id="status_information" cols="2" rows="2">{{ $asset->status_information }}</textarea>
                                            @error('status_information')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="photos">Foto</label>
                                            <input type="file" multiple name="photos[]" class="form-control"
                                                id="photos">
                                            {{-- Foreach images --}}
                                            <div class="row">
                                                @foreach ($asset->photos as $photo)
                                                    <div class="col-md-3 mt-3">
                                                        <img src="{{ Storage::url('asset/photos/' . $photo->photo) }}"
                                                            alt="{{ $photo->photo }}" width="200" class="img-fluid">
                                                        <button type="button" class="btn btn-danger btn-sm mt-2"
                                                            onclick="hapusFoto('{{ $photo->id }}')">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('photos')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Simpan Detail</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-home" role="tabpanel"
                            aria-labelledby="custom-tabs-one-home-tab">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Harga</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp.</span>
                                            </div>
                                            <input type="number" name="price" class="form-control" id="price"
                                                placeholder="Masukkan Harga Aset" value="{{ $asset->price }}">
                                        </div>
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_date">Tanggal Pembelian<span
                                                class="text-danger">*</span></label>
                                        <input type="date" name="purchase_date" class="form-control"
                                            id="purchase_date" placeholder="Masukkan Tanggal Pembelian"
                                            value="{{ $asset->purchase_date }}">
                                        @error('purchase_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="origin_of_purchase">Asal Pembelian</label>
                                        <input type="string" name="origin_of_purchase" class="form-control"
                                            id="origin_of_purchase" placeholder="Masukkan Nama Asal Pembelian"
                                            value="{{ $asset->origin_of_purchase }}">
                                        @error('origin_of_purchase')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="purchase_number">Nomor Pembelian</label>
                                        <input type="text" name="purchase_number" class="form-control"
                                            placeholder="Masukkan Nomor Pembelian Aset"
                                            value="{{ $asset->purchase_number }}">
                                        @error('purchase_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="warranty_id">Garansi</label>
                                        {{-- Select2 --}}
                                        <select name="warranty_id" class="form-control select2" id="warranty_id">
                                            <option value="">Tidak ada</option>
                                            @foreach ($warranties as $warranty)
                                                <option value="{{ $warranty->id }}"
                                                    {{ $warranty->id == $asset->warranty_id ? 'selected' : '' }}>
                                                    {{ $warranty->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('warranty_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Simpan Data Pembelian</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-mutation" role="tabpanel" aria-labelledby="tabs-mutation">
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Mutasi</th>
                                        <th>Lokasi Awal</th>
                                        <th>Lokasi Tujuan</th>
                                        <th>PIC Awal</th>
                                        <th>PIC Tujuan</th>
                                        <th>Pengguna Awal</th>
                                        <th>Pengguna Tujuan</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset->mutations as $mutation)
                                        <tr>
                                            <td>{{ $mutation->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $mutation->fromLocation->name }}</td>
                                            <td>{{ $mutation->toLocation->name }}</td>
                                            <td>{{ $mutation->fromPic->name }}</td>
                                            <td>{{ $mutation->toPic->name }}</td>
                                            <td>{{ $mutation->fromEmployee->name }}</td>
                                            <td>{{ $mutation->toEmployee->name }}</td>
                                            <td>{{ $mutation->status }}</td>
                                            <td>{{ $mutation->description ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabs-disposal" role="tabpanel" aria-labelledby="tabs-disposal">
                            <table class="table table-bordered" id="data-table">
                                <thead>
                                    <tr>
                                        <th>Tanggal Disposisi</th>
                                        <th>Project</th>
                                        <th>PIC</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset->disposal as $disposal)
                                        <tr>
                                            <td>{{ $disposal->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $disposal->project->name }}</td>
                                            <td>{{ $disposal->pic->name }}</td>
                                            <td>{{ $disposal->status }}</td>
                                            <td>{{ $disposal->description ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tabs-repair-cars" role="tabpanel"
                            aria-labelledby="tabs-repair-cars">
                            <button type="button" class="btn btn-primary mb-2" data-toggle="modal"
                                data-target="#modal-repair-car">Tambah Data</button>
                            {{-- Modal --}}
                            <div class="modal fade" id="modal-repair-car" tabindex="-1" role="dialog"
                                aria-labelledby="modal-repair-car" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mutationModalLabel">Tambah Data Servis Mobil</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.assets.repair-car.store') }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                                                <div class="form-group">
                                                    <label for="plate_number">Nomor Kendaraan</label>
                                                    <input type="text" class="form-control" id="plate_number"
                                                        name="plate_number" placeholder="Nomor Kendaraan">
                                                </div>
                                                <div class="form-group">
                                                    <label for="date">Tanggal Perbaikan</label>
                                                    <input type="date" class="form-control" id="date"
                                                        name="date">
                                                </div>
                                                <div class="form-group">
                                                    <label for="kilometers">Kilometer Terakhir</label>
                                                    <input type="number" class="form-control" id="kilometers"
                                                        name="kilometers">
                                                </div>
                                                <div class="form-group">
                                                    <label for="service_name">Nama Servis</label>
                                                    <input type="text" class="form-control" id="service_name"
                                                        name="service_name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="vendor">Vendor</label>
                                                    <input type="text" class="form-control" id="vendor"
                                                        name="vendor">
                                                </div>
                                                <div class="form-group">
                                                    <label for="price">Biaya Perbaikan</label>
                                                    <input type="number" class="form-control" id="price"
                                                        name="price">
                                                </div>
                                                <div class="form-group">
                                                    <label for="quantity">Kuantitas</label>
                                                    <input type="number" class="form-control" id="quantity"
                                                        name="quantity">
                                                </div>
                                                <div class="form-group">
                                                    <label for="unit">Satuan</label>
                                                    <input type="text" class="form-control" id="unit"
                                                        name="unit">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered" id="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal Perbaikan</th>
                                    <th>Plat Nomor</th>
                                    <th>Nama Servis</th>
                                    <th>Nama Vendor</th>
                                    <th>Kilometer Terakhir</th>
                                    <th>Kuantitas</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($asset->repair_car as $repair_car)
                                    <tr>
                                        {{-- <td>{{ $repair_car->date->format('d M Y H:i') }}</td> --}}
                                        <td>{{ $repair_car->date }}</td>
                                        <td>{{ $repair_car->plate_number }}</td>
                                        <td>{{ $repair_car->service_name }}</td>
                                        <td>{{ $repair_car->vendor }}</td>
                                        <td>{{ $repair_car->kilometers }}</td>
                                        <td>{{ $repair_car->quantity }}</td>
                                        <td>{{ $repair_car->unit }}</td>
                                        <td>{{ $repair_car->price }}</td>
                                        <td>{{ $repair_car->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
