@extends('layouts.app')

@section('title', __('Detail of Barangs'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Barang') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail data barang.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('barangs.index') }}">{{ __('Barang') }}</a>
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
                                        <td class="fw-bold">{{ __('Nama Barang') }}</td>
                                        <td>{{ $barang->nama_barang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Kode Barang') }}</td>
                                        <td>{{ $barang->kode_barang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Merk Model') }}</td>
                                        <td>{{ $barang->merk_model }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Ukuran') }}</td>
                                        <td>{{ $barang->ukuran }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Bahan') }}</td>
                                        <td>{{ $barang->bahan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Tahun Pembuatan Pembelian') }}</td>
                                        <td>{{ $barang->tahun_pembuatan_pembelian }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Satuan') }}</td>
                                        <td>{{ $barang->satuan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jml Barang') }}</td>
                                        <td>{{ $barang->jml_barang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Foto') }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $barang->foto_barang) }}" alt="{{ $barang->nama_barang }}"
                                                class="img-fluid" style="max-width: 200px" />
                                        </td>
                                   
                                </table>
                            </div>

                            <a href="{{ route('barangs.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
