@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editare produs</h1>
        <a href="{{ route('products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Înapoi la produse
        </a>
    </div>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produse</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editare: {{ $product->name }}</li>
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

    <!-- Formular de editare -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informații produs</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Informații de bază -->
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nume produs <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="description" class="form-label">Descriere</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                                    @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Preț (Lei) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                            @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stoc <span class="text-danger">*</span></label>
                                            <input type="number" min="0" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" required>
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
                                                <option value="{{ $category }}" {{ old('category', $product->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
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
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" value="{{ old('sku', $product->sku) }}">
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
                                        @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-2" style="max-height: 150px;">
                                        <div class="small text-muted mb-2">Imagine curentă</div>
                                        @else
                                        <img src="https://via.placeholder.com/200x150?text=Fără+imagine" alt="Fără imagine" class="img-fluid rounded mb-2">
                                        <div class="small text-muted mb-2">Nicio imagine</div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    <div class="small text-muted mt-1">Formatul acceptat: jpg, jpeg, png, gif. Max: 2MB.</div>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-check form-switch mb-3">
                                    <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" {{ old('featured', $product->featured) ? 'checked' : '' }}>
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
                                    <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand', $product->brand) }}">
                                    @error('brand')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" id="model" name="model" value="{{ old('model', $product->model) }}">
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
                                    <input type="text" class="form-control @error('weight') is-invalid @enderror" id="weight" name="weight" value="{{ old('weight', $product->weight) }}">
                                    @error('weight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="dimensions" class="form-label">Dimensiuni</label>
                                    <input type="text" class="form-control @error('dimensions') is-invalid @enderror" id="dimensions" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}">
                                    @error('dimensions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="warranty" class="form-label">Garanție</label>
                                    <input type="text" class="form-control @error('warranty') is-invalid @enderror" id="warranty" name="warranty" value="{{ old('warranty', $product->warranty) }}">
                                    @error('warranty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">Anulează</a>
                            <button type="submit" class="btn btn-primary">Salvează modificările</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Informații laterale -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informații suplimentare</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">ID produs:</span>
                        <span class="badge bg-secondary">{{ $product->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Status:</span>
                        <span class="badge {{ $product->stock > 0 ? ($product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success') : 'bg-danger' }}">
                            {{ $product->stock > 0 ? ($product->stock <= 5 ? 'Stoc redus' : 'În stoc') : 'Stoc epuizat' }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Data adăugării:</span>
                        <span>{{ $product->created_at->format('d.m.Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Ultima actualizare:</span>
                        <span>{{ $product->updated_at->format('d.m.Y') }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Sfaturi</h6>
                        <ul class="mb-0 ps-3">
                            <li>Adaugă o imagine pentru a crește vizibilitatea produsului</li>
                            <li>Descrierile detaliate îmbunătățesc rata de conversie</li>
                            <li>Marchează produsul ca "promovat" pentru a-l evidenția</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Acțiuni produs -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acțiuni produs</h6>
                </div>
                <div class="card-body">
                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm d-block mb-2">
                        <i class="fas fa-eye me-1"></i> Vizualizare produs
                    </a>
                    
                    <button type="button" class="btn btn-danger btn-sm d-block w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i> Șterge produs
                    </button>
                </div>
            </div>
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
</div>
@endsection 