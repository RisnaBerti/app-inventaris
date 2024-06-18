@extends('layouts.app')

@section('title', __('Laporan Inventaris'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Laporan') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('List data Laporan.') }}
                    </p>
                </div>
                <x-breadcrumb>
                    <li class="breadcrumb-item"><a href="/">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('Laporan') }}</li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <x-alert></x-alert>

            @can('pelaporan create')
                <div class="row mb-4">
                    <div class="col-md-3">
                        <select name="ruangan_id" id="ruangan_id" class="form-control">
                            <option value="">{{ __('Pilih Ruangan') }}</option>
                            @foreach ($ruangans as $ruangan)
                                <option value="{{ $ruangan->id }}">{{ $ruangan->nama_ruangan }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('ruangan_id'))
                            <span class="text-danger">{{ $errors->first('ruangan_id') }}</span>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="tahun_akademik" id="tahun_akademik" class="form-control"
                            placeholder="Tahun Akademik">
                        @if ($errors->has('tahun_akademik'))
                            <span class="text-danger">{{ $errors->first('tahun_akademik') }}</span>
                        @endif
                    </div>

                    <div class="col-md-3">
                        <button id="searchBtn" class="btn btn-primary mr-2">{{ __('Cari') }}</button>
                        <a href="{{ route('laporans.index') }}" class="btn btn-secondary"
                            id="resetBtn">{{ __('Reset') }}</a>
                        <a href="#" id="printBtn" target="_blank" class="btn btn-success">{{ __('Print') }}</a>
                    </div>
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
                                            <th rowspan="2">{{ __('No') }}</th>
                                            <th rowspan="2">{{ __('Tempat Simpan') }}</th>
                                            <th rowspan="2">{{ __('Nama Barang') }}</th>
                                            <th rowspan="2">{{ __('Kode Barang') }}</th>
                                            <th rowspan="2">{{ __('Merek/Model (Type)') }}</th>
                                            <th rowspan="2">{{ __('Ukuran') }}</th>
                                            <th rowspan="2">{{ __('Bahan') }}</th>
                                            <th rowspan="2">{{ __('Tahun Pembuatan/Pembelian') }}</th>
                                            <th rowspan="2">{{ __('Total') }}</th>
                                            <th rowspan="2">{{ __('No Inventaris') }}</th>
                                            <th rowspan="2">{{ __('Tahun Akademik') }}</th>
                                            <th colspan="3">{{ __('Keadaan') }}</th>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Baik (B)') }}</th>
                                            <th>{{ __('Kurang Baik (KB)') }}</th>
                                            <th>{{ __('Rusak Berat (RB)') }}</th>
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
        $(document).ready(function() {
            var table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('laporans.index') }}",
                    data: function(d) {
                        d.ruangan_id = $('#ruangan_id').val();
                        d.tahun_akademik = $('#tahun_akademik').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'ruangan',
                        name: 'ruangans.nama_ruangan'
                    },
                    {
                        data: 'nama_barang',
                        name: 'barangs.nama_barang'
                    },
                    {
                        data: 'kode_barang',
                        name: 'barangs.kode_barang'
                    },
                    {
                        data: 'merk_model',
                        name: 'barangs.merk_model'
                    },
                    {
                        data: 'ukuran',
                        name: 'barangs.ukuran'
                    },
                    {
                        data: 'bahan',
                        name: 'barangs.bahan'
                    },
                    {
                        data: 'tahun_pembuatan_pembelian',
                        name: 'barangs.tahun_pembuatan_pembelian'
                    },
                    {
                        data: 'jml_mutasi',
                        name: 'transaks.jml_mutasi'
                    },
                    {
                        data: 'no_inventaris',
                        name: 'no_inventaris'
                    },
                    {
                        data: 'tahun_akademik',
                        name: 'transaks.tahun_akademik'
                    },
                    {
                        data: 'jml_baik',
                        name: 'jml_baik'
                    },
                    {
                        data: 'jml_kurang_baik',
                        name: 'jml_kurang_baik'
                    },
                    {
                        data: 'jml_rusak_berat',
                        name: 'jml_rusak_berat'
                    }
                ]
            });

            $('#searchBtn').click(function() {
                table.draw();
            });

            $('#resetBtn').click(function() {
                $('#ruangan_id').val('');
                $('#tahun_akademik').val('');
                table.draw();
            });

            $('#printBtn').click(function() {
                //jalankan route laporans/print
                window.open("{{ route('laporans.print') }}?ruangan_id=" + $('#ruangan_id').val() +
                    "&tahun_akademik=" + $('#tahun_akademik').val(), "_blank");
            });
        });
    </script>
@endpush
