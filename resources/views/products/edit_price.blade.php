@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Modifică prețul</h1>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produse</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.show', $product->id) }}">{{ $product->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifică prețul</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modificare preț pentru "{{ $product->name }}"</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update-price', $product->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="current_price" class="form-label text-muted">Preț curent</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light">Lei</span>
                                        <input type="text" class="form-control bg-light" id="current_price" value="{{ number_format($product->price, 2) }}" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Preț nou</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Lei</span>
                                        <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Anulează</a>
                            <button type="submit" class="btn btn-primary">Salvează modificările</button>
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
                        <p class="mb-1 text-muted small">STOC</p>
                        <p class="font-weight-bold">{{ $product->stock }} bucăți</p>
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
@endsection 