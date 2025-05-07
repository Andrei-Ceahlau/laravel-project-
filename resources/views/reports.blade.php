@extends('layouts.app')

@section('title', 'Rapoarte')

@section('header', 'Rapoarte')

@section('breadcrumbs')
<li class="breadcrumb-item active">Rapoarte</li>
@endsection

@section('content')
<!-- Page Header -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Rapoarte & Analize</h4>
                    <p class="text-muted mb-0">Vizualizează statistici și analize pentru afacerea ta</p>
                </div>
                <div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Opțiuni</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf me-2 text-danger"></i>Export PDF</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2 text-success"></i>Export Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv me-2 text-primary"></i>Export CSV</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Tipărire</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Date Range & Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Interval</label>
                        <select class="form-select">
                            <option value="today">Astăzi</option>
                            <option value="yesterday">Ieri</option>
                            <option value="week">Ultima săptămână</option>
                            <option value="month" selected>Ultima lună</option>
                            <option value="quarter">Ultimul trimestru</option>
                            <option value="year">Ultimul an</option>
                            <option value="custom">Interval personalizat</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Categorie raport</label>
                        <select class="form-select">
                            <option value="sales" selected>Vânzări</option>
                            <option value="products">Produse</option>
                            <option value="customers">Clienți</option>
                            <option value="finances">Finanțe</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <label class="form-label">Grupare</label>
                        <select class="form-select">
                            <option value="day">Zi</option>
                            <option value="week" selected>Săptămână</option>
                            <option value="month">Lună</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Report Charts -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="card-title mb-0">Statistici de vânzări</h5>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-secondary active">Zilnic</button>
                    <button type="button" class="btn btn-outline-secondary">Săptămânal</button>
                    <button type="button" class="btn btn-outline-secondary">Lunar</button>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <div style="height: 300px; background: linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                            <h5 class="text-gray-600">Grafic vânzări (prezentare)</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="card-title mb-0">Distribuția vânzărilor</h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <div style="height: 300px; background: linear-gradient(45deg, rgba(236, 72, 153, 0.1) 0%, rgba(239, 68, 68, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <div class="text-center">
                            <i class="fas fa-chart-pie fa-3x mb-3 text-danger"></i>
                            <h5 class="text-gray-600">Grafic distribuție (prezentare)</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sales by Product & Geography -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="card-title mb-0">Top Produse</h5>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Produs</th>
                                <th scope="col">Vânzări</th>
                                <th scope="col">Valoare</th>
                                <th scope="col">Tendință</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>iPhone 13 Pro</td>
                                <td>42</td>
                                <td>231,000 RON</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up me-1"></i>24%</span></td>
                            </tr>
                            <tr>
                                <td>MacBook Pro</td>
                                <td>35</td>
                                <td>287,000 RON</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up me-1"></i>18%</span></td>
                            </tr>
                            <tr>
                                <td>Samsung Smart TV</td>
                                <td>58</td>
                                <td>104,400 RON</td>
                                <td><span class="badge bg-danger"><i class="fas fa-arrow-down me-1"></i>5%</span></td>
                            </tr>
                            <tr>
                                <td>PlayStation 5</td>
                                <td>29</td>
                                <td>72,500 RON</td>
                                <td><span class="badge bg-success"><i class="fas fa-arrow-up me-1"></i>32%</span></td>
                            </tr>
                            <tr>
                                <td>Canon EOS R5</td>
                                <td>17</td>
                                <td>246,500 RON</td>
                                <td><span class="badge bg-warning"><i class="fas fa-equals me-1"></i>0%</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                <h5 class="card-title mb-0">Vânzări după Regiune</h5>
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-download"></i>
                </button>
            </div>
            <div class="card-body">
                <div style="height: 250px; background: linear-gradient(45deg, rgba(139, 92, 246, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt fa-3x mb-3 text-primary"></i>
                        <h5 class="text-gray-600">Hartă distribuție vânzări (prezentare)</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- KPI Cards -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Indicatori cheie de performanță</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-4 text-primary mb-2">87,500</div>
                                <h5 class="card-title">Venituri totale (RON)</h5>
                                <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>12.5% vs perioada anterioară</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-4 text-success mb-2">181</div>
                                <h5 class="card-title">Număr comenzi</h5>
                                <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>8.3% vs perioada anterioară</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-4 text-warning mb-2">483</div>
                                <h5 class="card-title">Valoare medie comandă</h5>
                                <p class="text-success mb-0"><i class="fas fa-arrow-up me-1"></i>3.7% vs perioada anterioară</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body text-center">
                                <div class="display-4 text-danger mb-2">43</div>
                                <h5 class="card-title">Clienți noi</h5>
                                <p class="text-danger mb-0"><i class="fas fa-arrow-down me-1"></i>2.1% vs perioada anterioară</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 