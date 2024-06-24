@extends('layouts.app')

@section('title', __('Detail of Transaks'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Transaksi') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail data transaksi.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('transaks.index') }}">{{ __('Transaksi') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ __('Detail') }}
                    </li>
                </x-breadcrumb>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <tr>
                                        <td class="fw-bold">{{ __('Barang') }}</td>
                                        <td>{{ $transak->barang ? $transak->barang->nama_barang : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Ruangan') }}</td>
                                        <td>{{ $transak->ruangan ? $transak->ruangan->nama_ruangan : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tgl Mutasi') }}</td>
                                        <td>{{ isset($transak->tgl_mutasi) ? $transak->tgl_mutasi->format('d/m/Y') : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jenis Mutasi') }}</td>
                                        <td>{{ $transak->jenis_mutasi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tahun Akademik') }}</td>
                                        <td>{{ $transak->tahun_akademik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Periode') }}</td>
                                        <td>{{ isset($transak->periode) ? $transak->periode->format('m/Y') : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Mutasi') }}</td>
                                        <td>{{ $transak->jml_mutasi }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tempat Asal') }}</td>
                                        <td>{{ $transak->tempat_asal }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('No Inventaris') }}</td>
                                        <td>{{ $transak->no_inventaris }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('QR Code') }}</td>                                       
                                        <td>
                                            <img src="{{ asset('storage/uploads/qrcodes/' .  $transak->qrcode ) }}" alt="{{  $transak->qrcode }}"
                                            class="img-thumbnail" style="max-width: 200px" />
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ route('transaks.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
