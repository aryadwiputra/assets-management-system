@extends('layouts.dashboard')

@section('title', 'Edit Aset')

@push('style')
    @include('style.select2')
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="add-data-form" action="{{ route('dashboard.assets.update', $asset->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company_id">Perusahaan <span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="company_id" class="form-control select2" id="company_id">
                                @foreach ($companies as $company)
                                    <option value="{{ $company->id }}"
                                        {{ $company->id == $asset->company_id ? 'selected' : '' }}>{{ $company->name }}
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
                            <label for="location_id">Lokasi<span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="location_id" class="form-control select2" id="location_id">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $location->id == $asset->location_id ? 'selected' : '' }}>{{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
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
                                        {{ $status->id == $asset->status_id ? 'selected' : '' }}>{{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_of_measurement_id">Satuan<span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="unit_of_measurement_id" class="form-control select2" id="unit_of_measurement_id">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pic_id">Penanggung Jawab<span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="pic_id" class="form-control select2" id="pic_id">
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
                                        {{ $employee->id == $asset->employee_id ? 'selected' : '' }}>{{ $employee->name }}
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
                            <label for="department_id">Department<span class="text-danger">*</span></label>
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
                            <label for="category_id">Kategori Aset<span class="text-danger">*</span></label>
                            {{-- Select2 --}}
                            <select name="category_id" class="form-control select2" id="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $asset->category_id ? 'selected' : '' }}>{{ $category->name }}
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
                            <label for="serial_number">Nomor Seri</label>
                            <input type="text" name="serial_number" class="form-control"
                                value="{{ $asset->serial_number }}" placeholder="Masukkan Nomor Seri" id="serial_number">
                            @error('serial_number')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="number">Nomor Aset</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend" id="section_assets_number" style="display: none">
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
                            <label for="purchase_date">Tanggal Pembelian<span class="text-danger">*</span></label>
                            <input type="date" name="purchase_date" class="form-control" id="purchase_date"
                                placeholder="Masukkan Tanggal Pembelian" value="{{ $asset->purchase_date }}">
                            @error('purchase_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="origin_of_purchase">Asal Pembelian</label>
                            <input type="string" name="origin_of_purchase" class="form-control" id="origin_of_purchase"
                                placeholder="Masukkan Nama Asal Pembelian" value="{{ $asset->origin_of_purchase }}">
                            @error('origin_of_purchase')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="purchase_number">Nomor Pembelian</label>
                            <input type="text" name="purchase_number" class="form-control"
                                placeholder="Masukkan Nomor Pembelian Aset" value="{{ $asset->purchase_number }}">
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
                                        {{ $warranty->id == $asset->warranty_id ? 'selected' : '' }}>{{ $warranty->name }}
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
                            <label for="description">Deskripsi<span class="text-danger">*</span></label>
                            <textarea name="description" placeholder="Masukkan Deskripsi Pengguna Aset" class="form-control" id="description"
                                cols="2" rows="2">{{ $asset->description }}</textarea>
                            @error('description')
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
                            <label for="thumbnail">Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" id="thumbnail">
                            <img id="thumbnail-preview" alt="" class="img-fluid mt-3" width="300">
                            @error('thumbnail')
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
        $(document).ready(function() {
            $('#thumbnail').on('change', function() {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumbnail-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        });

        $(function() {
            // Inisialisasi Select2
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            // Data prefix untuk setiap company
            var prefixes = @json($companies->pluck('prefix_asset', 'id'));

            // Event ketika company_id berubah
            $('#company_id').on('change', function() {
                var selectedCompanyId = $(this).val();
                var prefixAsset = prefixes[selectedCompanyId];

                if (prefixAsset) {
                    $('#section_assets_number').show();
                    $('#assets_number').text(prefixAsset);
                } else {
                    $('#section_assets_number').hide();
                    $('#assets_number').text('');
                }
            });

            // Inisialisasi default saat halaman dimuat
            var defaultCompanyId = $('#company_id').val();
            if (defaultCompanyId && prefixes[defaultCompanyId]) {
                $('#section_assets_number').show();
                $('#assets_number').text(prefixes[defaultCompanyId]);
            } else {
                $('#section_assets_number').hide();
            }
        });
    </script>
@endpush
