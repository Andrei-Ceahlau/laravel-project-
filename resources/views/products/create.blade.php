@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Adaugă produs nou</h1>
        <a href="{{ route('products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Înapoi la produse
        </a>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produse</a></li>
            <li class="breadcrumb-item active" aria-current="page">Adaugă produs</li>
        </ol>
    </nav>
    
    <!-- Alert pentru erori -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Eroare!</strong> Verifică formularul pentru erori.
        <ul>
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Formular de adăugare -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informații produs</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Informații de bază -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nume produs <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descriere</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Preț (Lei) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                                            @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stoc <span class="text-danger">*</span></label>
                                            <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                                            @error('stock')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="category" class="form-label">Categorie <span class="text-danger">*</span></label>
                                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                                <option value="">Selectează categoria</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku') }}">
                                            @error('sku')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Imagine produs -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Imagine produs</label>
                                    <div class="mb-2">
                                        <img src="https://via.placeholder.com/200x150?text=Adaugă+imagine" alt="Placeholder" class="img-fluid rounded mb-2">
                                    </div>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    <div class="small text-muted mt-1">Formatul acceptat: jpg, jpeg, png, gif. Max: 2MB.</div>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="featured">Produs promovat</label>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Detalii suplimentare -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="brand" class="form-label">Marca</label>
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}">
                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model') }}">
                                    @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="weight" class="form-label">Greutate</label>
                                    <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight') }}">
                                    @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dimensions" class="form-label">Dimensiuni</label>
                                    <input type="text" class="form-control @error('dimensions') is-invalid @enderror" id="dimensions" name="dimensions" value="{{ old('dimensions') }}">
                                    @error('dimensions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="warranty" class="form-label">Garanție</label>
                                    <input type="text" class="form-control @error('warranty') is-invalid @enderror" id="warranty" name="warranty" value="{{ old('warranty') }}">
                                    @error('warranty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Anulează</a>
                            <button type="submit" class="btn btn-primary">Adaugă produs</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Informații laterale -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ghid de adăugare</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Sfaturi</h6>
                        <ul class="mb-0 ps-3">
                            <li>Adaugă o imagine pentru a crește vizibilitatea produsului</li>
                            <li>Descrierile detaliate îmbunătățesc rata de conversie</li>
                            <li>Marchează produsul ca "promovat" pentru a-l evidenția</li>
                        </ul>
                    </div>
                    
                    <div class="small text-muted">
                        <p><strong>Câmpuri obligatorii:</strong></p>
                        <ul>
                            <li>Nume produs</li>
                            <li>Preț</li>
                            <li>Stoc</li>
                            <li>Categorie</li>
                        </ul>
                        
                        <p><strong>Tipuri de fișiere acceptate:</strong></p>
                        <ul>
                            <li>Imagini: JPG, JPEG, PNG, GIF</li>
                            <li>Dimensiune maximă: 2MB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 