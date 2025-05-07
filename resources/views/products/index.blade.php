@extends('layouts.app')

@section('title', 'Produse')

@section('header', 'Produse')

@section('breadcrumbs')
<li class="breadcrumb-item active">Produse</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Produse</h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Adaugă produs
            </a>
            <a href="{{ route('products.export') }}?{{ http_build_query(request()->all()) }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Export
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filtre</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Caută</label>
                    <input type="text" class="form-control" id="search" name="search" placeholder="Nume produs..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="category" class="form-label">Categorie</label>
                    <select class="form-select" id="category" name="category">
                        @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Toate</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>În stoc</option>
                        <option value="low_stock" {{ request('status') == 'low_stock' ? 'selected' : '' }}>Stoc redus</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Stoc epuizat</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filtrează</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Resetează</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Produse Grid View -->
    <div class="row" id="grid-view">
        @if(count($products) > 0)
            @foreach($products as $product)
            <div class="col-xl-3 col-md-4 col-sm-6 mb-4">
                <div class="card product-card h-100 shadow">
                    @if($product->image)
                    <div class="product-image" style="background-image: url('{{ asset('storage/' . $product->image) }}');"></div>
                    @else
                    <div class="product-image" style="background-image: url('https://via.placeholder.com/400x200?text=No+Image');"></div>
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $product->name }}</h5>
                        <p class="card-text">
                            <span class="badge bg-secondary">{{ $product->category }}</span>
                            <span class="d-block mt-2 fw-bold text-primary">{{ number_format($product->price, 2) }} Lei</span>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->stock_status == 'in_stock')
                                <span class="badge bg-success">În stoc ({{ $product->stock }})</span>
                                @elseif($product->stock_status == 'low_stock')
                                <span class="badge bg-warning text-dark">Stoc redus ({{ $product->stock }})</span>
                                @else
                                <span class="badge bg-danger">Stoc epuizat</span>
                                @endif
                            </div>
                            <div>
                                <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent d-flex justify-content-between">
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> Vizualizare
                        </a>
                        <div>
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i> Editare
                            </a>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-outline-success {{ $product->stock <= 0 ? 'disabled' : '' }}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @else
        <div class="col-12">
            <div class="alert alert-info">
                Nu există produse disponibile. <a href="{{ route('products.create') }}" class="alert-link">Adaugă un produs nou</a>.
            </div>
        </div>
        @endif
    </div>

    <!-- Produse List View (Hidden by default) -->
    <div class="card shadow mb-4 d-none" id="list-view">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Lista produse</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagine</th>
                            <th>Nume</th>
                            <th>Categorie</th>
                            <th>Preț</th>
                            <th>Stoc</th>
                            <th>Status</th>
                            <th>Data adăugării</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($products) > 0)
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="40" class="rounded">
                                    @else
                                    <img src="https://via.placeholder.com/40" alt="{{ $product->name }}" class="rounded">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category }}</td>
                                <td>{{ number_format($product->price, 2) }} Lei</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    @if($product->stock_status == 'in_stock')
                                    <span class="badge bg-success">În stoc</span>
                                    @elseif($product->stock_status == 'low_stock')
                                    <span class="badge bg-warning text-dark">Stoc redus</span>
                                    @else
                                    <span class="badge bg-danger">Stoc epuizat</span>
                                    @endif
                                </td>
                                <td>{{ $product->created_at->format('d.m.Y') }}</td>
                                <td>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $product->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">Confirmare ștergere</h5>
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
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center">Nu există produse disponibile.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- View Toggle Buttons -->
    <div class="mb-4 text-center">
        <div class="btn-group" role="group" aria-label="View Toggle">
            <button type="button" class="btn btn-primary active" id="grid-view-btn">
                <i class="fas fa-th-large"></i> Grid
            </button>
            <button type="button" class="btn btn-outline-primary" id="list-view-btn">
                <i class="fas fa-list"></i> Listă
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle view buttons
        const gridViewBtn = document.getElementById('grid-view-btn');
        const listViewBtn = document.getElementById('list-view-btn');
        const gridView = document.getElementById('grid-view');
        const listView = document.getElementById('list-view');
        
        gridViewBtn.addEventListener('click', function() {
            gridView.classList.remove('d-none');
            listView.classList.add('d-none');
            gridViewBtn.classList.add('active');
            gridViewBtn.classList.remove('btn-outline-primary');
            gridViewBtn.classList.add('btn-primary');
            listViewBtn.classList.remove('active');
            listViewBtn.classList.remove('btn-primary');
            listViewBtn.classList.add('btn-outline-primary');
        });
        
        listViewBtn.addEventListener('click', function() {
            gridView.classList.add('d-none');
            listView.classList.remove('d-none');
            listViewBtn.classList.add('active');
            listViewBtn.classList.remove('btn-outline-primary');
            listViewBtn.classList.add('btn-primary');
            gridViewBtn.classList.remove('active');
            gridViewBtn.classList.remove('btn-primary');
            gridViewBtn.classList.add('btn-outline-primary');
        });
    });
</script>
@endsection 