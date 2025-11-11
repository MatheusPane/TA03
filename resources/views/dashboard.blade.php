{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.layout')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<style>
    :root {
        --pkk-green: #2e7d32;
        --pkk-gold: #ffb300;
        --pkk-blue: #1565c0;
        --pkk-red: #c62828;
        --pkk-dark: #1a1a1a;
        --pkk-light: #f8f9fa;
    }

    .stat-card {
        background: linear-gradient(135deg, var(--bg-from), var(--bg-to));
        border-radius: 1rem;
        padding: 1.5rem;
        color: white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border: none;
        height: 100%;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 100px; height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(30px, -30px);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }

    .stat-value {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0.5rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .stat-label {
        font-size: 0.95rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .chart-card {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border: 1px solid rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
    }

    .chart-card:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        transform: translateY(-5px);
    }

    .chart-header {
        padding: 1.2rem 1.5rem;
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: 1px solid rgba(0,0,0,0.08);
        background: linear-gradient(to right, var(--header-from), var(--header-to));
        color: white;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    .chart-body {
        padding: 1.5rem;
        background: white;
    }

    @media (max-width: 768px) {
        .stat-value { font-size: 1.8rem; }
        .stat-card { padding: 1.2rem; }
        .chart-header { font-size: 1rem; padding: 1rem; }
    }
</style>
@endpush

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-1 fw-bold text-primary">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard PKK
                    </h2>
                    <p class="text-muted mb-0">Selamat datang, {{ Auth::user()->name }}!</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <small class="text-muted">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ now()->format('d F Y') }}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <!-- STATISTIK UTAMA -->
            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="stat-card" style="--bg-from: #1e88e5; --bg-to: #1565c0;">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalWarga) }}</div>
                        <div class="stat-label">Total Warga</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card" style="--bg-from: #43a047; --bg-to: #2e7d32;">
                        <div class="stat-icon">
                            <i class="fas fa-home"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalKeluarga) }}</div>
                        <div class="stat-label">Total Keluarga</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card" style="--bg-from: #fb8c00; --bg-to: #f57c00;">
                        <div class="stat-icon">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalDasawisma) }}</div>
                        <div class="stat-label">Dasawisma Aktif</div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="stat-card" style="--bg-from: #c62828; --bg-to: #b71c1c;">
                        <div class="stat-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </div>
                        <div class="stat-value">{{ number_format($totalDusun) }}</div>
                        <div class="stat-label">Total Dusun</div>
                    </div>
                </div>
            </div>

            <!-- CHART SECTION -->
            <div class="row g-4">
                <!-- Warga per Dusun -->
                <div class="col-lg-6">
                    <div class="chart-card">
                        <div class="chart-header" style="--header-from: #1e88e5; --header-to: #42a5f5;">
                            <i class="fas fa-chart-bar me-2"></i>Warga per Dusun
                        </div>
                        <div class="chart-body">
                            <div id="chart-dusun"></div>
                        </div>
                    </div>
                </div>

                <!-- Warga per Agama -->
                <div class="col-lg-6">
                    <div class="chart-card">
                        <div class="chart-header" style="--header-from: #43a047; --header-to: #66bb6a;">
                            <i class="fas fa-chart-pie me-2"></i>Komposisi Agama
                        </div>
                        <div class="chart-body">
                            <div id="chart-agama"></div>
                        </div>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-4">
                    <div class="chart-card h-100">
                        <div class="chart-header" style="--header-from: #8e24aa; --header-to: #ab47bc;">
                            <i class="fas fa-venus-mars me-2"></i>Jenis Kelamin
                        </div>
                        <div class="chart-body">
                            <div id="chart-jk"></div>
                        </div>
                    </div>
                </div>

                <!-- Status Perkawinan -->
                <div class="col-md-4">
                    <div class="chart-card h-100">
                        <div class="chart-header" style="--header-from: #fb8c00; --header-to: #ffa726;">
                            <i class="fas fa-ring me-2"></i>Status Perkawinan
                        </div>
                        <div class="chart-body">
                            <div id="chart-perkawinan"></div>
                        </div>
                    </div>
                </div>

                <!-- Pendidikan -->
                <div class="col-md-4">
                    <div class="chart-card h-100">
                        <div class="chart-header" style="--header-from: #d81b60; --header-to: #ec407a;">
                            <i class="fas fa-graduation-cap me-2"></i>Tingkat Pendidikan
                        </div>
                        <div class="chart-body">
                            <div id="chart-pendidikan"></div>
                        </div>
                    </div>
                </div>

                <!-- Pekerjaan -->
                <div class="col-12">
                    <div class="chart-card">
                        <div class="chart-header" style="--header-from: #546e7a; --header-to: #78909c;">
                            <i class="fas fa-briefcase me-2"></i>Jenis Pekerjaan
                        </div>
                        <div class="chart-body">
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
// Data dari Controller
const dataWarga = @json($rekapWarga);

// Format angka
const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

// 1. Warga per Dusun
new ApexCharts(document.querySelector("#chart-dusun"), {
    series: [{ name: 'Jumlah Warga', data: Object.values(dataWarga.dusun) }],
    chart: { type: 'bar', height: 320, toolbar: { show: true } },
    plotOptions: { bar: { horizontal: true, borderRadius: 8, dataLabels: { position: 'top' } } },
    colors: ['#1e88e5'],
    dataLabels: { enabled: true, offsetX: 30, style: { fontSize: '12px', fontWeight: 600 } },
    xaxis: { categories: Object.keys(dataWarga.dusun), labels: { style: { fontWeight: 600 } } },
    yaxis: { labels: { style: { fontWeight: 500 } } },
    grid: { borderColor: '#e0e0e0', strokeDashArray: 3 },
    tooltip: { y: { formatter: formatNumber } }
}).render();

// 2. Agama
new ApexCharts(document.querySelector("#chart-agama"), {
    series: Object.values(dataWarga.agama),
    chart: { type: 'donut', height: 320 },
    labels: Object.keys(dataWarga.agama),
    colors: ['#2e7d32', '#ffb300', '#1565c0', '#c62828', '#6a1b9a'],
    legend: { position: 'bottom', fontSize: '13px', markers: { width: 12, height: 12 } },
    dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' },
    tooltip: { y: { formatter: formatNumber } },
    responsive: [{ breakpoint: 480, options: { chart: { width: 280 } } }]
}).render();

// 3. Jenis Kelamin
new ApexCharts(document.querySelector("#chart-jk"), {
    series: Object.values(dataWarga.jk),
    chart: { type: 'pie', height: 260 },
    labels: ['Laki-laki', 'Perempuan'],
    colors: ['#1565c0', '#e91e63'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: true, formatter: (val) => Math.round(val) + '%' }
}).render();

// 4. Status Perkawinan
new ApexCharts(document.querySelector("#chart-perkawinan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.perkawinan) }],
    chart: { type: 'bar', height: 240 },
    colors: ['#fb8c00'],
    xaxis: { categories: Object.keys(dataWarga.perkawinan) },
    dataLabels: { enabled: true, style: { fontWeight: 600 } },
    plotOptions: { bar: { borderRadius: 6 } }
}).render();

// 5. Pendidikan
new ApexCharts(document.querySelector("#chart-pendidikan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pendidikan) }],
    chart: { type: 'bar', height: 240 },
    plotOptions: { bar: { horizontal: true, borderRadius: 6 } },
    colors: ['#d81b60'],
    xaxis: { categories: Object.keys(dataWarga.pendidikan) },
    dataLabels: { enabled: true, offsetX: 30 }
}).render();

// 6. Pekerjaan
new ApexCharts(document.querySelector("#chart-pekerjaan"), {
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pekerjaan) }],
    chart: { type: 'bar', height: 380 },
    plotOptions: { bar: { horizontal: true, borderRadius: 8 } },
    colors: ['#546e7a'],
    xaxis: { categories: Object.keys(dataWarga.pekerjaan) },
    dataLabels: { enabled: true, offsetX: 35, style: { fontWeight: 600 } },
    grid: { borderColor: '#e0e0e0' },
    tooltip: { y: { formatter: formatNumber } }
}).render();
</script>
@endpush