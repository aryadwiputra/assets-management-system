@extends('layouts.main')

@section('title', 'Beranda')

@section('content')
    <div class="container">
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $asset->name }}</h3>
                        <div class="col-12">
                            <img src="{{ Storage::url('asset/thumbnails/' . $asset->thumbnail) ?? asset('dist/img/prod-1.jpg') }}"
                                class="product-image" alt="Product Image">
                        </div>
                        {{-- <div class="col-12 product-image-thumbs">
                            <div class="product-image-thumb active"><img src="../../dist/img/prod-1.jpg"
                                    alt="Product Image"></div>
                            <div class="product-image-thumb"><img src="../../dist/img/prod-2.jpg" alt="Product Image"></div>
                            <div class="product-image-thumb"><img src="../../dist/img/prod-3.jpg" alt="Product Image"></div>
                            <div class="product-image-thumb"><img src="../../dist/img/prod-4.jpg" alt="Product Image"></div>
                            <div class="product-image-thumb"><img src="../../dist/img/prod-5.jpg" alt="Product Image"></div>
                        </div> --}}
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $asset->name }}</h3>
                        <hr>

                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Nomor Aset</th>
                                    <td>{{ $asset->number }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Seri</th>
                                    <td>{{ $asset->serial_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pengguna</th>
                                    <td>{{ $asset->employee->name }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $asset->location->name }}</td>
                                </tr>
                                <tr>
                                    <th>Penanggung Jawab</th>
                                    <td>{{ $asset->person_in_charge->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>{{ $asset->description }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        {{ $asset->status->name }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        {{--  --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
