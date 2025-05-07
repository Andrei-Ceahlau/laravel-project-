@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Adaugă stoc</h1>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produse</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Adaugă stoc</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Adaugă stoc pentru "{{ $product->name }}"</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update-add-stock', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_stock" class="form-label text-muted">Stoc curent</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light" id="current_stock" value="{{ $product->stock }} bucăți" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Cantitate de adăugat</label>
                                    <div class="input-group">
                                        <input type="number" min="1" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" required>
                                        <span class="input-group-text">bucăți</span>
                                        @error('quantity')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_stock" class="form-label">Stoc nou estimat</label>
                            <div class="input-group">
                                <input type="text" class="form-control bg-light" id="new_stock" value="{{ $product->stock + 1 }} bucăți" disabled>
                            </div>
                            <div class="form-text">Această valoare se va actualiza automat când modificați cantitatea.</div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Anulează</a>
                            <button type="submit" class="btn btn-success">Adaugă stoc</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informații produs</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded me-3" style="max-width: 60px;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-secondary"></i>
                            </div>
                        @endif
                        <div>
                            <h5 class="mb-0">{{ $product->name }}</h5>
                            <span class="badge bg-secondary">{{ $product->category }}</span>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">PREȚ</p>
                        <p class="font-weight-bold">{{ number_format($product->price, 2) }} Lei</p>
                    </div>
                    
                    <div class="mb-3">
                        <p class="mb-1 text-muted small">SKU</p>
                        <p class="font-weight-bold">{{ $product->sku ?? 'N/A' }}</p>
                    </div>
                    
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fas fa-arrow-left me-1"></i> Înapoi la detalii produs
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const newStockOutput = document.getElementById('new_stock');
        const currentStock = {{ $product->stock }};
        
        // Update the estimated new stock when quantity changes
        quantityInput.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 0;
            const newStock = currentStock + quantity;
            newStockOutput.value = newStock + ' bucăți';
        });
    });
</script>
@endsection
@endsection 