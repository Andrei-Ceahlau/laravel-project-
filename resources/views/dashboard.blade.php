@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@push('styles')
<style>
    /* Stiluri pentru grafic */
    .chart-area {
        position: relative;
        height: 300px;
        margin-bottom: 1rem;
    }
    
    .chart-area canvas {
        height: 100% !important;
        width: 100% !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="dashboard-header d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="text-muted mb-0">Bine ai venit! Iată statisticile și activitatea recentă</p>
        </div>
    </div>

    <!-- Content Row - Stats Cards -->
    <div class="row">
        <!-- Utilizatori Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">
                                Utilizatori</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $stats['users']['count'] }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-arrow-up me-1"></i>{{ $stats['users']['growth'] }}% față de luna trecută
                            </div>
                        </div>
                        <div class="p-3 rounded-circle bg-primary bg-opacity-10">
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produse Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">
                                Produse</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $stats['products']['count'] }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-arrow-up me-1"></i>{{ $stats['products']['growth'] }}% față de luna trecută
                            </div>
                        </div>
                        <div class="p-3 rounded-circle bg-success bg-opacity-10">
                            <i class="fas fa-shopping-cart fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produse în stoc Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">
                                Produse în stoc</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $stats['stock']['count'] }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-arrow-up me-1"></i>{{ $stats['stock']['growth'] }}% față de luna trecută
                            </div>
                        </div>
                        <div class="p-3 rounded-circle bg-info bg-opacity-10">
                            <i class="fas fa-boxes fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produse promovate Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card hover-lift h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-muted">
                                Produse promovate</div>
                            <div class="h1 mb-0 font-weight-bold">{{ $stats['featured']['count'] }}</div>
                            <div class="mt-2 text-success small">
                                <i class="fas fa-arrow-up me-1"></i>{{ $stats['featured']['growth'] }}% față de luna trecută
                            </div>
                        </div>
                        <div class="p-3 rounded-circle bg-warning bg-opacity-10">
                            <i class="fas fa-star fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Charts -->
    <div class="row">
        <!-- Sales Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Vânzări lunare (date reale din comenzi)</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Ultimele 6 luni</a></li>
                            <li><a class="dropdown-item" href="#">Ultimul an</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Exportă date</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="position: relative; height: 300px; width: 100%;">
                        <div id="chartLoading" class="chart-loading">
                            <div class="chart-loading-spinner"></div>
                        </div>
                        <canvas id="salesChart" style="min-height: 250px;"></canvas>
                    </div>
                    <div class="row mt-4 text-center">
                        <div class="col-md-4 border-end">
                            <h3 class="h5 fw-bold text-primary">{{ $chartData['growth'] }}%</h3>
                            <p class="text-muted small mb-0">Creștere</p>
                        </div>
                        <div class="col-md-4 border-end">
                            <h3 class="h5 fw-bold text-primary">{{ $chartData['newClients'] }}</h3>
                            <p class="text-muted small mb-0">Clienți noi</p>
                        </div>
                        <div class="col-md-4">
                            <h3 class="h5 fw-bold text-primary">{{ $chartData['avgOrder'] }} Lei</h3>
                            <p class="text-muted small mb-0">Comandă medie</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produse populare -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Produse populare</h6>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-primary">
                        Vezi toate
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($popularProducts as $product)
                        <a href="{{ route('products.show', $product->id) }}" class="list-group-item list-group-item-action d-flex align-items-center py-3 px-4">
                            <div class="flex-shrink-0">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50" height="50" class="rounded shadow-sm">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1 fw-bold">{{ $product->name }}</h6>
                                    <span class="badge bg-primary rounded-pill">{{ $product->price }} Lei</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    @if($product->stock_status == 'in_stock')
                                        <span class="badge bg-success me-2">În stoc</span>
                                    @elseif($product->stock_status == 'low_stock')
                                        <span class="badge bg-warning text-dark me-2">Stoc redus</span>
                                    @else
                                        <span class="badge bg-danger me-2">Stoc epuizat</span>
                                    @endif
                                    <small class="text-muted">{{ $product->category }}</small>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - Recent Activity -->
    <div class="row">
        <!-- Eventual alt conținut poate fi adăugat aici -->
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementul de loading
        const chartLoading = document.getElementById('chartLoading');
        
        // Datele pentru grafic
        const labels = @json($chartData['labels']);
        const dataVanzari = @json($chartData['sales']);
        
        // Verificăm dacă Chart.js este disponibil
        if (typeof Chart === 'undefined') {
            // Încărcăm Chart.js dinamic dacă nu este disponibil
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js';
            script.onload = function() {
                // După încărcare, inițializăm graficul
                initializeChart();
            };
            document.head.appendChild(script);
        } else {
            // Chart.js este deja disponibil, inițializăm graficul direct
            initializeChart();
        }
        
        function initializeChart() {
            const canvas = document.getElementById('salesChart');
            
            if (!canvas) {
                console.error('Nu s-a găsit elementul canvas pentru graficul de vânzări!');
                if (chartLoading) chartLoading.style.display = 'none';
                return;
            }
            
            // Creăm un nou grafic
            const salesChart = new Chart(canvas, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Vânzări lunare (RON)',
                        data: dataVanzari,
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: 'rgb(79, 70, 229)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: 'white',
                        pointBorderColor: 'rgb(79, 70, 229)',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeOutQuart',
                        onComplete: function() {
                            // Ascundem animația de încărcare când graficul este gata
                            if (chartLoading) chartLoading.style.display = 'none';
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'white',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ccc',
                            borderWidth: 1,
                            padding: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toLocaleString('ro-RO') + ' RON';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value + ' RON';
                                }
                            }
                        }
                    }
                }
            });
            
            console.log('Graficul a fost inițializat cu succes!');
        }
    });
</script>
@endsection 