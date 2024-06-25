@extends('layouts.app')

@section('title', __('Detail of Jenjangs'))

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-8 order-md-1 order-last">
                    <h3>{{ __('Jenjang') }}</h3>
                    <p class="text-subtitle text-muted">
                        {{ __('Detail data jenjang.') }}
                    </p>
                </div>

                <x-breadcrumb>
                    <li class="breadcrumb-item">
                        <a href="/">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('jenjangs.index') }}">{{ __('Jenjang') }}</a>
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
                                        <td class="fw-bold">{{ __('Kode Jenjang') }}</td>
                                        <td>{{ $jenjang->kode_jenjang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama Jenjang') }}</td>
                                        <td>{{ $jenjang->nama_jenjang }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Nama Sekolah') }}</td>
                                        <td>{{ $jenjang->nama_sekolah }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">{{ __('Logo') }}</td>
                                        <td>
                                            <img src="{{ asset('storage/uploads/logos/' . $jenjang->foto_jenjang) }}" alt="{{ $jenjang->nama_jenjang }}"
                                            class="img-thumbnail" style="max-width: 200px" />
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <a href="{{ route('jenjangs.index') }}" class="btn btn-secondary">{{ __('Back') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
