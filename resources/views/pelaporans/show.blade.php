@extends('layouts.app')

@section('title', __('Detail of Pelaporans'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Inventaris') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail data inventaris.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pelaporans.index') }}">{{ __('Inventaris') }}</a>
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
                                    {{-- <tr>
                                        <td class="fw-bold">{{ __('Barang') }}</td>
                                        <td>{{ $pelaporan->barang ? $pelaporan->barang->nama_barang : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Ruangan') }}</td>
                                        <td>{{ $pelaporan->ruangan ? $pelaporan->ruangan->nama_ruangan : '' }}</td>
                                    </tr> --}}
                                    <tr>
                                        <td class="fw-bold">{{ __('Transak') }}</td>
                                        <td>{{ $pelaporan->transak ? $pelaporan->transak->barang_id : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('No Inventaris') }}</td>
                                        <td>{{ $pelaporan->no_inventaris }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Baik') }}</td>
                                        <td>{{ $pelaporan->jml_baik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Kurang Baik') }}</td>
                                        <td>{{ $pelaporan->jml_kurang_baik }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Rusak Berat') }}</td>
                                        <td>{{ $pelaporan->jml_rusak_berat }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Hilang') }}</td>
                                        <td>{{ $pelaporan->jml_hilang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Keterangan') }}</td>
                                        <td>{{ $pelaporan->keterangan }}</td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ route('pelaporans.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
