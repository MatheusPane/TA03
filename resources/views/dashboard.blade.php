@extends('layouts.layout')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" />
@endpush

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Dashboard</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <!-- CARD REKAPITULASI -->
            <div class="row g-3 mb-4">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $totalWarga }}</h3>
                            <p>Total Warga</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{ $totalKeluarga }}</h3>
                            <p>Total Keluarga</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 13.5c1.38 0 2.5-1.12 2.5-2.5S10.38 8.5 9 8.5 6.5 9.62 6.5 11s1.12 2.5 2.5 2.5zm6 0c1.38 0 2.5-1.12 2.5-2.5S16.38 8.5 15 8.5 12.5 9.62 12.5 11s1.12 2.5 2.5 2.5zm-3 4c-2.33 0-7 1.17-7 3.5V22h14v-1c0-2.33-4.67-3.5-7-3.5z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>{{ $totalDasawisma }}</h3>
                            <p>Total Dasawisma</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-9 14l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>{{ $totalDusun }}</h3>
                            <p>Total Dusun</p>
                        </div>
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- CHART ROW -->
            <div class="row">
                <!-- Chart: Warga per Dusun -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Warga per Dusun</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-dusun"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Warga per Agama -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Warga per Agama</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-agama"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Jenis Kelamin -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">Jenis Kelamin</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-jk"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Status Perkawinan -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Status Perkawinan</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-perkawinan"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Pendidikan -->
                <div class="col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Pendidikan</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-pendidikan"></div>
                        </div>
                    </div>
                </div>

                <!-- Chart: Pekerjaan -->
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-dark text-white">
                            <h5 class="mb-0">Pekerjaan</h5>
                        </div>
                        <div class="card-body">
                            <div id="chart-pekerjaan"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
// === DATA DARI CONTROLLER ===
const dataWarga = @json($rekapWarga);

// 1. Chart: Warga per Dusun
new ApexCharts(document.querySelector("#chart-dusun"), {
    series: [{ name: 'Jumlah Warga', data: Object.values(dataWarga.dusun) }],
    chart: { type: 'bar', height: 350 },
    plotOptions: { bar: { horizontal: true } },
    colors: ['#0d6efd'],
    xaxis: { categories: Object.keys(dataWarga.dusun) },
    title: { text: '' }
}).render();

// 2. Chart: Warga per Agama
new ApexCharts(document.querySelector("#chart-agama"), {
    series: Object.values(dataWarga.agama),
    chart: { type: 'donut', height: 350 },
    labels: Object.keys(dataWarga.agama),
    colors: ['#28a745', '#ffc107', '#dc3545', '#007bff', '#6f42c1'],
    legend: { position: 'bottom' },
    responsive: [{
        breakpoint: 480,
        options: { chart: { width: 300 }, legend: { position: 'bottom' } }
    }]
}).render();

// 3. Chart: Jenis Kelamin
new ApexCharts(document.querySelector("#chart-jk"), {
    series: Object.values(dataWarga.jk),
    chart: { type: 'pie' },
    labels: ['Laki-laki', 'Perempuan'],
    colors: ['#0d6efd', '#e91e63']
}).render();

// 4. Chart: Status Perkawinan
new ApexCharts(document.querySelector("#chart-perkawinan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.perkawinan) }],
    chart: { type: 'bar', height: 250 },
    xaxis: { categories: Object.keys(dataWarga.perkawinan) },
    colors: ['#17a2b8']
}).render();

// 5. Chart: Pendidikan
new ApexCharts(document.querySelector("#chart-pendidikan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pendidikan) }],
    chart: { type: 'bar', height: 250 },
    plotOptions: { bar: { horizontal: true } },
    xaxis: { categories: Object.keys(dataWarga.pendidikan) },
    colors: ['#dc3545']
}).render();

// 6. Chart: Pekerjaan
new ApexCharts(document.querySelector("#chart-pekerjaan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pekerjaan) }],
    chart: { type: 'bar', height: 350 },
    plotOptions: { bar: { horizontal: true } },
    xaxis: { categories: Object.keys(dataWarga.pekerjaan) },
    colors: ['#6c757d']
}).render();
</script>
@endpush