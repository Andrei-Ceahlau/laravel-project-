@extends('layouts.app')

@section('title', 'Bine ai venit')

@section('header', 'Dashboard')

@section('breadcrumbs')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Dashboard Header Section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1">Bine ai venit, Ionuț!</h4>
                    <p class="text-muted mb-0">Verifică ultimele actualizări și statisticile de astăzi</p>
                </div>
                <div class="d-flex">
                    <button class="btn btn-primary me-2">
                        <i class="fas fa-download me-2"></i>Raport
                    </button>
                    <div class="dropdown">
                        <button class="btn btn-light" type="button" id="dashboardActions" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dashboardActions">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-sync-alt me-2"></i>Actualizează date</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Setări dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-question-circle me-2"></i>Ajutor</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card h-100 stat-card bg-gradient-primary text-white">
            <div class="card-body">
                <i class="fas fa-users icon-big"></i>
                <div class="d-flex flex-column">
                    <span class="stat-label">Utilizatori</span>
                    <span class="stat-value">120</span>
                    <div class="d-flex align-items-center mt-3">
                        <div class="badge bg-white text-primary me-2">
                            <i class="fas fa-arrow-up me-1"></i>15%
                        </div>
                        <small>vs luna trecută</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 stat-card bg-gradient-success text-white">
            <div class="card-body">
                <i class="fas fa-shopping-cart icon-big"></i>
                <div class="d-flex flex-column">
                    <span class="stat-label">Vânzări</span>
                    <span class="stat-value">760</span>
                    <div class="d-flex align-items-center mt-3">
                        <div class="badge bg-white text-success me-2">
                            <i class="fas fa-arrow-up me-1"></i>22%
                        </div>
                        <small>vs luna trecută</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 stat-card bg-gradient-warning text-white">
            <div class="card-body">
                <i class="fas fa-star icon-big"></i>
                <div class="d-flex flex-column">
                    <span class="stat-label">Recenzii</span>
                    <span class="stat-value">256</span>
                    <div class="d-flex align-items-center mt-3">
                        <div class="badge bg-white text-warning me-2">
                            <i class="fas fa-arrow-up me-1"></i>8%
                        </div>
                        <small>vs luna trecută</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 stat-card bg-gradient-danger text-white">
            <div class="card-body">
                <i class="fas fa-comments icon-big"></i>
                <div class="d-flex flex-column">
                    <span class="stat-label">Comentarii</span>
                    <span class="stat-value">543</span>
                    <div class="d-flex align-items-center mt-3">
                        <div class="badge bg-white text-danger me-2">
                            <i class="fas fa-arrow-up me-1"></i>12%
                        </div>
                        <small>vs luna trecută</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Row -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Acțiuni rapide</h6>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#" class="btn btn-light">
                        <i class="fas fa-plus-circle me-2 text-success"></i>Adaugă produs
                    </a>
                    <a href="#" class="btn btn-light">
                        <i class="fas fa-user-plus me-2 text-primary"></i>Adaugă utilizator
                    </a>
                    <a href="#" class="btn btn-light">
                        <i class="fas fa-chart-bar me-2 text-info"></i>Rapoarte
                    </a>
                    <a href="#" class="btn btn-light">
                        <i class="fas fa-cog me-2 text-secondary"></i>Setări
                    </a>
                    <a href="#" class="btn btn-light">
                        <i class="fas fa-question-circle me-2 text-warning"></i>Ajutor
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="row">
    <!-- Chart Section -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Raport Vânzări</h5>
                    <div class="d-flex">
                        <div class="btn-group me-2">
                            <button type="button" class="btn btn-sm btn-outline-primary active">Zilnic</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Săptămânal</button>
                            <button type="button" class="btn btn-sm btn-outline-primary">Lunar</button>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="chartDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="chartDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-download me-2"></i>Export PDF</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel me-2"></i>Export Excel</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Tipărire</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-share-alt me-2"></i>Partajează</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <div class="text-center">
                        <h5 class="mb-3 text-muted">Vânzări lunare (RON)</h5>
                        <div style="height: 270px; background: linear-gradient(45deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <div class="text-center">
                                <i class="fas fa-chart-line fa-3x mb-3 text-primary"></i>
                                <h5 class="text-gray-600">Grafic vânzări (prezentare)</h5>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4 border-end">
                            <div class="text-center p-3">
                                <h3 class="mb-0 fw-bold text-primary">45,250 RON</h3>
                                <small class="text-muted text-uppercase">Total Vânzări</small>
                                <div class="mt-2 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i> 12.5% vs luna trecută
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 border-end">
                            <div class="text-center p-3">
                                <h3 class="mb-0 fw-bold text-primary">125</h3>
                                <small class="text-muted text-uppercase">Clienți Noi</small>
                                <div class="mt-2 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i> 5.7% vs luna trecută
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-3">
                                <h3 class="mb-0 fw-bold text-primary">362 RON</h3>
                                <small class="text-muted text-uppercase">Valoare medie comandă</small>
                                <div class="mt-2 text-success small">
                                    <i class="fas fa-arrow-up me-1"></i> 2.3% vs luna trecută
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Members -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Utilizatori Recenți</h5>
                    <span class="badge bg-primary">8 noi</span>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item user-list-item p-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="avatar-sm rounded-circle me-3" alt="User">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">Alexandru Popescu</h6>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-2">alex@example.com</small>
                                    <span class="badge bg-success">Nou</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Mesaj</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item user-list-item p-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="avatar-sm rounded-circle me-3" alt="User">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">Mirela Ionescu</h6>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-2">mirela@example.com</small>
                                    <span class="badge bg-success">Nou</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Mesaj</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item user-list-item p-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="avatar-sm rounded-circle me-3" alt="User">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">Andrei Dumitru</h6>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-2">andrei@example.com</small>
                                    <span class="badge bg-secondary">Activ</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Mesaj</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item user-list-item p-3">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/40" class="avatar-sm rounded-circle me-3" alt="User">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">Ioana Mihai</h6>
                                <div class="d-flex align-items-center">
                                    <small class="text-muted me-2">ioana@example.com</small>
                                    <span class="badge bg-secondary">Activ</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-icon btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profil</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-envelope me-2"></i>Mesaj</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="card-footer text-center border-top">
                <a href="#" class="btn btn-sm btn-primary px-4">
                    <i class="fas fa-users me-2"></i>Vezi toți utilizatorii
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders and Products -->
<div class="row">
    <!-- Recent Orders Table -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Comenzi Recente</h5>
                <button class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Adaugă Comandă
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th>ID Comandă</th>
                                <th>Client</th>
                                <th>Produs</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Acțiuni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#ORD-0945</td>
                                <td>Ion Popescu</td>
                                <td>Samsung Smart TV</td>
                                <td><span class="badge bg-success">Finalizat</span></td>
                                <td>1,800 RON</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Vezi</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Editează</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-0944</td>
                                <td>Maria Dumitrescu</td>
                                <td>iPhone 13 Pro</td>
                                <td><span class="badge bg-warning">În procesare</span></td>
                                <td>5,500 RON</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Vezi</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Editează</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-0943</td>
                                <td>Andrei Popa</td>
                                <td>MacBook Pro</td>
                                <td><span class="badge bg-info">Expediat</span></td>
                                <td>8,200 RON</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Vezi</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Editează</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>#ORD-0942</td>
                                <td>Elena Ionescu</td>
                                <td>PlayStation 5</td>
                                <td><span class="badge bg-danger">Anulat</span></td>
                                <td>2,500 RON</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i>Vezi</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Editează</a></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Șterge</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-end">
                <button class="btn btn-sm btn-outline-primary">Vezi toate comenzile</button>
            </div>
        </div>
    </div>

    <!-- Best Selling Products -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Produse Populare</h5>
                <button class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-poll me-1"></i> Raport
                </button>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3 p-2 border rounded">
                    <img src="https://via.placeholder.com/45" class="me-3" alt="Product">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">Samsung Smart TV</h6>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <small class="text-muted">(128)</small>
                        </div>
                    </div>
                    <h6 class="mb-0 text-success">1,800 RON</h6>
                </div>
                <div class="d-flex align-items-center mb-3 p-2 border rounded">
                    <img src="https://via.placeholder.com/45" class="me-3" alt="Product">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">iPhone 13 Pro</h6>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <small class="text-muted">(245)</small>
                        </div>
                    </div>
                    <h6 class="mb-0 text-success">5,500 RON</h6>
                </div>
                <div class="d-flex align-items-center mb-3 p-2 border rounded">
                    <img src="https://via.placeholder.com/45" class="me-3" alt="Product">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">MacBook Pro</h6>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                            </div>
                            <small class="text-muted">(98)</small>
                        </div>
                    </div>
                    <h6 class="mb-0 text-success">8,200 RON</h6>
                </div>
                <div class="d-flex align-items-center p-2 border rounded">
                    <img src="https://via.placeholder.com/45" class="me-3" alt="Product">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">PlayStation 5</h6>
                        <div class="d-flex align-items-center">
                            <div class="text-warning me-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <small class="text-muted">(156)</small>
                        </div>
                    </div>
                    <h6 class="mb-0 text-success">2,500 RON</h6>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-sm btn-primary">Vezi toate produsele</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  // Poți adăuga scripturi suplimentare pentru dashboard aici
  console.log('Dashboard loaded!');
</script>
@endpush
