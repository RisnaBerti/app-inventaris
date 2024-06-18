@extends('layouts.app')

@section('title', __('Detail of Pegawais'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Pegawai') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail data pegawai.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('pegawais.index') }}">{{ __('Pegawai') }}</a>
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
                                        <td class="fw-bold">{{ __('User') }}</td>
                                        <td>{{ $pegawai->user ? $pegawai->user->name : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Jabatan') }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('No Tlpn') }}</td>
                                        <td>{{ $pegawai->no_tlpn }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Alamat') }}</td>
                                        <td>{{ $pegawai->alamat }}</td>
                                    </tr>

                                </table>
                            </div>

                            <a href="{{ route('pegawais.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
