@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalii produs</h1>
        <div>
            <a href="{{ route('products.edit', $product->id) }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editează produs
            </a>
            <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm ml-2" data-bs-toggle="modal" data-bs-target="#deleteModal">
                <i class="fas fa-trash fa-sm text-white-50"></i> Șterge produs
            </button>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmare ștergere</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Ești sigur că vrei să ștergi produsul <strong>{{ $product->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Șterge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produse</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <!-- Product Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informații produs</h6>
                    <div class="d-flex">
                        <span class="badge {{ $product->stock_status == 'in_stock' ? 'bg-success' : ($product->stock_status == 'low_stock' ? 'bg-warning text-dark' : 'bg-danger') }} me-2">
                            {{ $product->stock_status == 'in_stock' ? 'În stoc' : ($product->stock_status == 'low_stock' ? 'Stoc redus' : 'Stoc epuizat') }}
                        </span>
                        @if($product->featured)
                        <span class="badge bg-primary">Promovat</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-4 mb-md-0">
                            <div class="mb-3">
                                @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded">
                                @else
                                <img src="https://via.placeholder.com/400x400?text=No+Image" alt="{{ $product->name }}" class="img-fluid rounded">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h2 class="h4 font-weight-bold">{{ $product->name }}</h2>
                            <p class="mb-2 text-muted">Categorie: <span class="badge bg-secondary">{{ $product->category }}</span></p>
                            
                            <div class="mb-4">
                                <h3 class="h5 text-primary font-weight-bold">{{ number_format($product->price, 2) }} Lei</h3>
                            </div>
                            
                            <div class="mb-4">
                                <p>{{ $product->description }}</p>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <p class="mb-1 text-muted small">STOC</p>
                                    <p class="font-weight-bold">{{ $product->stock }} bucăți</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1 text-muted small">SKU</p>
                                    <p class="font-weight-bold">{{ $product->sku ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1 text-muted small">MARCA</p>
                                    <p class="font-weight-bold">{{ $product->brand ?? 'N/A' }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="mb-1 text-muted small">MODEL</p>
                                    <p class="font-weight-bold">{{ $product->model ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="mt-4">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    <div class="input-group me-3" style="width: 120px;">
                                        <span class="input-group-text">Cantitate</span>
                                        <input type="number" class="form-control" name="quantity" value="1" min="1" max="{{ $product->stock }}">
                                    </div>
                                    <button type="submit" class="btn btn-primary {{ $product->stock <= 0 ? 'disabled' : '' }}">
                                        <i class="fas fa-cart-plus me-2"></i> Adaugă în coș
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Specifications -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Specificații tehnice</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 30%">Dimensiuni</th>
                                    <td>{{ $product->dimensions ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Greutate</th>
                                    <td>{{ $product->weight ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Garanție</th>
                                    <td>{{ $product->warranty ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Data adăugării</th>
                                    <td>{{ $product->created_at->format('d.m.Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Ultima actualizare</th>
                                    <td>{{ $product->updated_at->format('d.m.Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Stock Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stoc și inventar</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h4 class="small font-weight-bold">Nivel stoc <span class="float-end">{{ min(100, ($product->stock / 50) * 100) }}%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar {{ $product->stock_status == 'in_stock' ? 'bg-success' : ($product->stock_status == 'low_stock' ? 'bg-warning' : 'bg-danger') }}" role="progressbar" style="width: {{ min(100, ($product->stock / 50) * 100) }}%" aria-valuenow="{{ $product->stock }}" aria-valuemin="0" aria-valuemax="50"></div>
                        </div>
                    </div>
                    
                    <div class="row text-center mb-4">
                        <div class="col-6 border-end">
                            <div class="h4 font-weight-bold">{{ $product->stock }}</div>
                            <div class="small text-muted">În stoc</div>
                        </div>
                        <div class="col-6">
                            <div class="h4 font-weight-bold">0</div>
                            <div class="small text-muted">Rezervate</div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.add-stock', $product->id) }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Adaugă stoc
                        </a>
                        <a href="{{ route('products.adjust-stock', $product->id) }}" class="btn btn-warning" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-minus me-2"></i>Ajustează stoc
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Product Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acțiuni rapide</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editare produs
                        </a>
                        <a href="{{ route('products.edit-price', $product->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-tag me-2"></i>Modifică prețul
                        </a>
                        <form action="{{ route('products.duplicate', $product->id) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">
                                <i class="fas fa-clone me-2"></i>Duplică produs
                            </button>
                        </form>
                        <a href="{{ route('products.report', $product->id) }}" class="btn btn-outline-info">
                            <i class="fas fa-download me-2"></i>Raport produs
                        </a>
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Șterge produs
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Similar Products -->
    @if(count($similarProducts) > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Produse similare</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($similarProducts as $similarProduct)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        @if($similarProduct->image)
                        <div class="product-image" style="height: 150px; background-image: url('{{ asset('storage/' . $similarProduct->image) }}');"></div>
                        @else
                        <div class="product-image" style="height: 150px; background-image: url('https://via.placeholder.com/150?text=No+Image');"></div>
                        @endif
                        
                        <div class="card-body">
                            <h5 class="card-title text-truncate">{{ $similarProduct->name }}</h5>
                            <p class="card-text">
                                <span class="d-block fw-bold text-primary">{{ number_format($similarProduct->price, 2) }} Lei</span>
                                <small class="text-muted">{{ $similarProduct->category }}</small>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('products.show', $similarProduct->id) }}" class="btn btn-sm btn-outline-primary w-100">
                                <i class="fas fa-eye me-1"></i> Detalii
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection