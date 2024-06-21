@extends('layouts.app')

@section('title', __('Transaks'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Transaksi') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('List semua data transaksi.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Transaksi') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('transak create')
                <div class="d-flex justify-content-end">
                    <a href="{{ route('transaks.create') }}" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        {{ __('Tambah data') }}
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
                                            <th>{{ __('Barang') }}</th>
                                            <th>{{ __('Ruangan') }}</th>
                                            <th>{{ __('No Inventaris') }}</th>
                                            <th>{{ __('Jenis Pengadaan') }}</th>
                                            <th>{{ __('Tgl Mutasi') }}</th>
                                            <th>{{ __('Jenis Mutasi') }}</th>
                                            <th>{{ __('Tahun Akademik') }}</th>
                                            <th>{{ __('Periode') }}</th>
                                            <th>{{ __('Total Barang') }}</th>
                                            <th>{{ __('Tempat Asal') }}</th>
                                            <th>{{ __('QR Code') }}</th>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.css" />
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.0/datatables.min.js"></script>
    <script>
        $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaks.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    data: 'nama_ruangan',
                    name: 'nama_ruangan'
                },
                {
                    data: 'no_inventaris',
                    name: 'no_inventaris'
                },
                {
                    data: 'jenis_pengadaan',
                    name: 'jenis_pengadaan'
                },
                {
                    data: 'tgl_mutasi',
                    name: 'tgl_mutasi',
                },
                {
                    data: 'jenis_mutasi',
                    name: 'jenis_mutasi',
                },
                {
                    data: 'tahun_akademik',
                    name: 'tahun_akademik',
                },
                {
                    data: 'periode',
                    name: 'periode',
                },
                {
                    data: 'jml_mutasi',
                    name: 'jml_mutasi',
                },
                // {
                //     data: 'jml_baik',
                //     name: 'jml_baik',
                // },
                // {
                //     data: 'jml_kurang_baik',
                //     name: 'jml_kurang_baik',
                // },
                // {
                //     data: 'jml_rusak_berat',
                //     name: 'jml_rusak_berat',
                // },
                {
                    data: 'tempat_asal',
                    name: 'tempat_asal',
                },
                {
                    data: 'qrcode',
                    name: 'qrcode',
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
