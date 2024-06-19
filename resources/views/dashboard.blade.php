@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>

    {{-- hitung total barang, total user, total ruangan --}}
    @php
        $total_barang = \App\Models\Barang::count();
        $total_user = \App\Models\User::count();
        $total_ruangan = \App\Models\Ruangan::count();
    @endphp


    <div class="page-content">
        <section class="row">
            <div class="col-12 ">
                <div class="row">
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon purple mb-2">
                                            <i class="archive"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Pegawai</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_user }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Ruangan</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_ruangan }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-4 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldAdd-User"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Jumlah Kategori Barang</h6>
                                        <h6 class="font-extrabold mb-0">{{ $total_barang }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-4 py-4-5">
                                <div class="row">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldBookmark"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                        <h6 class="text-muted font-semibold">Saved Post</h6>
                                        <h6 class="font-extrabold mb-0">112</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Jumlah Inventaris Per Tahun</h4>
                                <form method="GET" action="{{ route('dashboard') }}">
                                    <select name="year" onchange="this.form.submit()">
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ $year == $selectedYear ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                            <div class="card-body">
                                <div id="chart-inventaris"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Parse the JSON-encoded data passed from the backend
            const data = @json($formattedData);

            // Extract unique item names for x-axis categories
            const itemNames = [...new Set(data.map(item => item.nama_barang))];

            // Initialize series data structure
            const series = [];

            // Extract ruangan names and corresponding jml_mutasi values for each item
            const ruanganMap = {};
            data.forEach(item => {
                if (!ruanganMap[item.ruangan]) {
                    ruanganMap[item.ruangan] = Array(itemNames.length).fill(0);
                }
                const index = itemNames.indexOf(item.nama_barang);
                ruanganMap[item.ruangan][index] = item.jml_mutasi;
            });

            // Populate the series array with ruangan data
            for (const [ruangan, jmlMutasi] of Object.entries(ruanganMap)) {
                series.push({
                    name: ruangan,
                    data: jmlMutasi
                });
            }

            // Configure the chart options
            const options = {
                chart: {
                    type: 'bar'
                },
                series: series,
                xaxis: {
                    categories: itemNames
                }
            };

            // Render the chart
            const chart = new ApexCharts(document.querySelector("#chart-inventaris"), options);
            chart.render();
        });
    </script>

    {{-- <div class="page-content">
        <section class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible show fade">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <h4>Hi 👋, {{ auth()->user()->name }}</h4>
                        <p>{{ __('Selamat datang di SISTEM INVENTARIS!') }}</p>
                    </div>
                </div>
            </div>
        </section>
    </div> --}}
@endsection
