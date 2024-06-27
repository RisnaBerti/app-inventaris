@extends('layouts.app')

@section('title', __('Jenjangs'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Jenjang') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('List semua data jenjang.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Jenjang') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

                @can('jenjang create')
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('jenjangs.create') }}" class="btn btn-primary mb-3">
                            <i class="fas fa-plus"></i>
                            {{ __('Tambah Data') }}
                        </a>
                    </div>
                @endcan

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive p-1">
                                <table class="table table-striped" id="data-table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('No') }}</th>
                                            <th>{{ __('Kode Jenjang') }}</th>
											<th>{{ __('Nama Jenjang') }}</th>
                                            <th>{{ __('Nama Sekolah') }}</th>
                                            <th>{{ __('Foto') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('jenjangs.index') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_jenjang',
                    name: 'kode_jenjang',
                },
				{
                    data: 'nama_jenjang',
                    name: 'nama_jenjang',
                },
                {
                    data: 'nama_sekolah',
                    name: 'nama_sekolah',
                },
                {
                    data: 'foto_jenjang',
                    name: 'foto_jenjang',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        if (data) {
                            // Cek jika data adalah tautan PDF
                            if (data.endsWith('.pdf')) {
                                var fileName = data.split('/').pop();
                                return `<a href="${data}" target="_blank">${fileName}</a>`;
                            } else {
                                // Jika bukan PDF, maka asumsikan data adalah URL gambar
                                return `
                                        <img src="${data}" class="img-thumbnail" class="img-thumbnail" width="50" height="50" style="object-fit: cover alt="Logo"  >
                                   `;
                            }
                        } else {
                            // Tampilkan placeholder jika data dokumen kosong
                            return `
                                    <img src="https://via.placeholder.com/350?text=No+Image+Available" alt="No Image Available">
                               `;
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endpush
