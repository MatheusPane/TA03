{{-- resources/views/dashboard.blade.php --}}
@extends('layouts.layout')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" />
<style>
    /* Stat Cards */
    .stat-card {
        background: linear-gradient(135deg, var(--card-from), var(--card-to));
        border-radius: 12px;
        padding: 1.5rem;
        color: white;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
        border: none;
        height: 100%;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin: 0.5rem 0 0.25rem;
        letter-spacing: -0.02em;
    }

    .stat-label {
        font-size: 0.9rem;
        opacity: 0.95;
        font-weight: 500;
    }

    /* Chart Cards */
    .chart-card {
        background: var(--bg-sidebar);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
        border: 1px solid var(--border-color);
        transition: all 0.2s ease;
        height: 100%;
    }

    .chart-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .chart-header {
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        font-size: 1rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-sidebar);
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-header i {
        color: var(--primary);
        font-size: 1.125rem;
    }

    .chart-body {
        padding: 1.5rem;
        background: var(--bg-sidebar);
    }

    /* Welcome Section */
    .welcome-section {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 12px;
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .welcome-section h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .welcome-section p {
        opacity: 0.95;
        margin: 0;
        font-size: 1rem;
    }

    .date-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.2);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        backdrop-filter: blur(10px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .stat-value { 
            font-size: 1.75rem; 
        }
        .stat-card { 
            padding: 1.25rem; 
        }
        .welcome-section {
            padding: 1.5rem;
        }
        .welcome-section h2 {
            font-size: 1.5rem;
        }
        .chart-header { 
            font-size: 0.9375rem; 
            padding: 1rem 1.25rem; 
        }
    }

    /* ApexCharts Custom */
    .apexcharts-tooltip {
        background: var(--bg-sidebar) !important;
        border: 1px solid var(--border-color) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
        color: var(--text-primary) !important;
    }

    .apexcharts-tooltip-title {
        background: var(--bg-content) !important;
        border-bottom: 1px solid var(--border-color) !important;
        color: var(--text-primary) !important;
    }

    .apexcharts-legend-text {
        color: var(--text-primary) !important;
    }

    .apexcharts-xaxis-label,
    .apexcharts-yaxis-label {
        fill: var(--text-secondary) !important;
    }

    .apexcharts-datalabel-label,
    .apexcharts-datalabel-value {
        fill: var(--text-primary) !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- WELCOME SECTION -->
    <div class="welcome-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard PKK Silalahi Dolok
                </h2>
                <p>Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>!</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="date-badge">
                    <i class="bi bi-calendar-check"></i>
                    <span>{{ now()->locale('id')->isoFormat('D MMMM Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- STATISTIK UTAMA -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-from: #2563eb; --card-to: #1e40af;">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-value">{{ number_format($totalWarga) }}</div>
                <div class="stat-label">Total Warga</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-from: #059669; --card-to: #047857;">
                <div class="stat-icon">
                    <i class="bi bi-house-heart-fill"></i>
                </div>
                <div class="stat-value">{{ number_format($totalKeluarga) }}</div>
                <div class="stat-label">Total Keluarga</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-from: #d97706; --card-to: #b45309;">
                <div class="stat-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>
                <div class="stat-value">{{ number_format($totalDasawisma) }}</div>
                <div class="stat-label">Dasawisma Aktif</div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="stat-card" style="--card-from: #dc2626; --card-to: #b91c1c;">
                <div class="stat-icon">
                    <i class="bi bi-geo-alt-fill"></i>
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
                <div class="chart-header">
                    <i class="bi bi-bar-chart-fill"></i>
                    Warga per Dusun
                </div>
                <div class="chart-body">
                    <div id="chart-dusun"></div>
                </div>
            </div>
        </div>

        <!-- Warga per Agama -->
        <div class="col-lg-6">
            <div class="chart-card">
                <div class="chart-header">
                    <i class="bi bi-pie-chart-fill"></i>
                    Komposisi Agama
                </div>
                <div class="chart-body">
                    <div id="chart-agama"></div>
                </div>
            </div>
        </div>

        <!-- Jenis Kelamin -->
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-header">
                    <i class="bi bi-gender-ambiguous"></i>
                    Jenis Kelamin
                </div>
                <div class="chart-body">
                    <div id="chart-jk"></div>
                </div>
            </div>
        </div>

        <!-- Status Perkawinan -->
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-header">
                    <i class="bi bi-heart-fill"></i>
                    Status Perkawinan
                </div>
                <div class="chart-body">
                    <div id="chart-perkawinan"></div>
                </div>
            </div>
        </div>

        <!-- Pendidikan -->
        <div class="col-md-4">
            <div class="chart-card">
                <div class="chart-header">
                    <i class="bi bi-mortarboard-fill"></i>
                    Tingkat Pendidikan
                </div>
                <div class="chart-body">
                    <div id="chart-pendidikan"></div>
                </div>
            </div>
        </div>

        <!-- Pekerjaan -->
        <div class="col-12">
            <div class="chart-card">
                <div class="chart-header">
                    <i class="bi bi-briefcase-fill"></i>
                    Jenis Pekerjaan
                </div>
                <div class="chart-body">
                    <div id="chart-pekerjaan"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"></script>
<script>
// Data dari Controller
const dataWarga = @json($rekapWarga);

// Get current theme
const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';

// Get CSS variables
const getCSSVar = (varName) => {
    return getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
};

const textColor = getCSSVar('--text-primary');
const textSecondary = getCSSVar('--text-secondary');
const borderColor = getCSSVar('--border-color');
const bgColor = getCSSVar('--bg-sidebar');

// Format angka
const formatNumber = (num) => new Intl.NumberFormat('id-ID').format(num);

// Common chart options
const commonOptions = {
    chart: {
        fontFamily: 'Source Sans 3, sans-serif',
        toolbar: { show: false },
        animations: { enabled: true, speed: 800 },
        background: 'transparent'
    },
    grid: {
        borderColor: borderColor,
        strokeDashArray: 3,
        padding: { top: 0, right: 0, bottom: 0, left: 10 }
    },
    tooltip: {
        theme: isDark ? 'dark' : 'light',
        style: { fontSize: '13px' },
        y: { formatter: formatNumber }
    },
    dataLabels: {
        style: { 
            fontSize: '12px', 
            fontWeight: 600,
            colors: ['#fff']
        }
    },
    legend: {
        fontSize: '13px',
        fontWeight: 500,
        labels: { colors: textColor }
    }
};

// 1. Warga per Dusun
new ApexCharts(document.querySelector("#chart-dusun"), {
    ...commonOptions,
    series: [{ name: 'Jumlah Warga', data: Object.values(dataWarga.dusun) }],
    chart: { ...commonOptions.chart, type: 'bar', height: 320 },
    plotOptions: { 
        bar: { 
            horizontal: true, 
            borderRadius: 8,
            dataLabels: { position: 'top' }
        } 
    },
    colors: ['#2563eb'],
    dataLabels: { 
        enabled: true, 
        offsetX: 30,
        style: { 
            fontSize: '12px', 
            fontWeight: 600, 
            colors: ['#2563eb']
        }
    },
    xaxis: { 
        categories: Object.keys(dataWarga.dusun),
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.dusun).length).fill(textSecondary),
                fontSize: '12px',
                fontWeight: 500
            }
        }
    },
    yaxis: { 
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.dusun).length).fill(textSecondary),
                fontSize: '12px',
                fontWeight: 500
            }
        } 
    }
}).render();

// 2. Agama
new ApexCharts(document.querySelector("#chart-agama"), {
    ...commonOptions,
    series: Object.values(dataWarga.agama),
    chart: { ...commonOptions.chart, type: 'donut', height: 320 },
    labels: Object.keys(dataWarga.agama),
    colors: ['#059669', '#2563eb', '#d97706', '#dc2626', '#7c3aed'],
    legend: { 
        position: 'bottom',
        fontSize: '13px',
        fontWeight: 500,
        labels: { colors: textColor },
        markers: { width: 10, height: 10, radius: 3 }
    },
    dataLabels: { 
        enabled: true,
        formatter: (val) => Math.round(val) + '%',
        style: { 
            fontSize: '13px', 
            fontWeight: 600,
            colors: ['#fff']
        }
    },
    plotOptions: {
        pie: {
            donut: {
                size: '65%',
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Total',
                        fontSize: '14px',
                        fontWeight: 600,
                        color: textColor,
                        formatter: (w) => formatNumber(w.globals.seriesTotals.reduce((a, b) => a + b, 0))
                    },
                    value: {
                        color: textColor,
                        fontSize: '22px',
                        fontWeight: 700
                    }
                }
            }
        }
    },
    responsive: [{ 
        breakpoint: 480, 
        options: { 
            chart: { width: 280 },
            legend: { position: 'bottom' }
        } 
    }]
}).render();

// 3. Jenis Kelamin
new ApexCharts(document.querySelector("#chart-jk"), {
    ...commonOptions,
    series: Object.values(dataWarga.jk),
    chart: { ...commonOptions.chart, type: 'pie', height: 260 },
    labels: ['Laki-laki', 'Perempuan'],
    colors: ['#2563eb', '#ec4899'],
    legend: { 
        position: 'bottom',
        fontSize: '13px',
        fontWeight: 500,
        labels: { colors: textColor }
    },
    dataLabels: { 
        enabled: true, 
        formatter: (val) => Math.round(val) + '%',
        style: { 
            fontSize: '13px', 
            fontWeight: 600,
            colors: ['#fff']
        }
    }
}).render();

// 4. Status Perkawinan
new ApexCharts(document.querySelector("#chart-perkawinan"), {
    ...commonOptions,
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.perkawinan) }],
    chart: { ...commonOptions.chart, type: 'bar', height: 240 },
    colors: ['#d97706'],
    xaxis: { 
        categories: Object.keys(dataWarga.perkawinan),
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.perkawinan).length).fill(textSecondary),
                fontSize: '12px'
            }
        }
    },
    yaxis: { 
        labels: { 
            style: { 
                colors: textSecondary,
                fontSize: '12px'
            }
        } 
    },
    dataLabels: { 
        enabled: true, 
        style: { 
            fontSize: '12px', 
            fontWeight: 600, 
            colors: ['#d97706']
        }
    },
    plotOptions: { bar: { borderRadius: 6, columnWidth: '60%' } }
}).render();

// 5. Pendidikan
new ApexCharts(document.querySelector("#chart-pendidikan"), {
    ...commonOptions,
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pendidikan) }],
    chart: { ...commonOptions.chart, type: 'bar', height: 240 },
    plotOptions: { 
        bar: { 
            horizontal: true, 
            borderRadius: 6,
            dataLabels: { position: 'top' }
        } 
    },
    colors: ['#7c3aed'],
    xaxis: { 
        categories: Object.keys(dataWarga.pendidikan),
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.pendidikan).length).fill(textSecondary),
                fontSize: '12px'
            }
        }
    },
    yaxis: { 
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.pendidikan).length).fill(textSecondary),
                fontSize: '12px'
            }
        } 
    },
    dataLabels: { 
        enabled: true, 
        offsetX: 30,
        style: { 
            fontSize: '12px', 
            fontWeight: 600, 
            colors: ['#7c3aed']
        }
    }
}).render();

// 6. Pekerjaan
new ApexCharts(document.querySelector("#chart-pekerjaan"), {
    ...commonOptions,
    series: [{ name: 'Jumlah', data: Object.values(dataWarga.pekerjaan) }],
    chart: { ...commonOptions.chart, type: 'bar', height: 380 },
    plotOptions: { 
        bar: { 
            horizontal: true, 
            borderRadius: 8,
            dataLabels: { position: 'top' }
        } 
    },
    colors: ['#64748b'],
    xaxis: { 
        categories: Object.keys(dataWarga.pekerjaan),
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.pekerjaan).length).fill(textSecondary),
                fontSize: '12px'
            }
        }
    },
    yaxis: { 
        labels: { 
            style: { 
                colors: Array(Object.keys(dataWarga.pekerjaan).length).fill(textSecondary),
                fontSize: '12px'
            }
        } 
    },
    dataLabels: { 
        enabled: true, 
        offsetX: 35,
        style: { 
            fontSize: '12px', 
            fontWeight: 600, 
            colors: ['#0A65E3FF']
        }
    }
}).render();

// Update charts on theme change
document.addEventListener('DOMContentLoaded', function() {
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'data-bs-theme') {
                location.reload(); // Reload to apply new theme to charts
            }
        });
    });
    
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['data-bs-theme']
    });
});
</script>
@endpush