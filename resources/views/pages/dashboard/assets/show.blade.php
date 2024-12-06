@extends('layouts.dashboard')

@section('title', 'Edit Aset')

@push('style')
    @include('style.select2')
@endpush

@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                {{-- Thumbnail --}}
            </div>
        </div>
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
