@extends('layouts.app')

@section('title', 'Creare Comandă')

@section('header', 'Creare Comandă')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Comenzi</a></li>
<li class="breadcrumb-item active">Creare Comandă</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Creare Comandă Nouă</h1>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detalii Comandă</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <!-- Detalii Client -->
                        <div class="mb-4">
                            <h5 class="mb-3">Informații Client</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Nume Complet</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                    @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required>
                                    @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                    @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payment_method" class="form-label">Metodă de Plată</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="">Selectează metoda de plată</option>
                                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card bancar</option>
                                        <option value="transfer bancar" {{ old('payment_method') == 'transfer bancar' ? 'selected' : '' }}>Transfer bancar</option>
                                        <option value="ramburs" {{ old('payment_method') == 'ramburs' ? 'selected' : '' }}>Plată la livrare (ramburs)</option>
                                        <option value="PayPal" {{ old('payment_method') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                    </select>
                                    @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Adresa de Livrare -->
                        <div class="mb-4">
                            <h5 class="mb-3">Adresă de Livrare</h5>
                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Adresa Completă</label>
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                                @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Adresa de Facturare (dacă diferă)</label>
                                <textarea class="form-control @error('billing_address') is-invalid @enderror" id="billing_address" name="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                                @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Produse -->
                        <div class="mb-4">
                            <h5 class="mb-3">Produse</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="products-table">
                                    <thead>
                                        <tr>
                                            <th>Produs</th>
                                            <th>Preț</th>
                                            <th style="width: 120px;">Cantitate</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $index => $product)
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input product-checkbox" type="checkbox" id="product-{{ $product->id }}" name="selected_products[]" value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                                    <label class="form-check-label" for="product-{{ $product->id }}">
                                                        {{ $product->name }} 
                                                        @if($product->stock <= 5 && $product->stock > 0)
                                                            <span class="badge bg-warning text-dark">Stoc redus ({{ $product->stock }})</span>
                                                        @elseif($product->stock > 5)
                                                            <span class="badge bg-success">În stoc ({{ $product->stock }})</span>
                                                        @else
                                                            <span class="badge bg-danger">Stoc epuizat</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{ number_format($product->price, 2) }} Lei</td>
                                            <td>
                                                <input type="number" class="form-control product-quantity" 
                                                    name="products[{{ $product->id }}][quantity]" 
                                                    min="1" max="{{ $product->stock }}" value="1" 
                                                    data-price="{{ $product->price }}" 
                                                    data-id="{{ $product->id }}" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                            </td>
                                            <td class="product-total">0.00 Lei</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="alert alert-info mt-2">
                                <i class="fas fa-info-circle me-2"></i> Selectează cel puțin un produs pentru a putea crea comanda.
                            </div>
                        </div>
                        
                        <!-- Note Comandă -->
                        <div class="mb-4">
                            <h5 class="mb-3">Informații Suplimentare</h5>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Note Comandă</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('orders.index') }}" class="btn btn-secondary me-md-2">Anulează</a>
                            <button type="submit" class="btn btn-primary">Salvează Comanda</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sumar Comandă</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="order-subtotal">0.00 Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>TVA (19%):</span>
                        <span id="order-tax">0.00 Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livrare:</span>
                        <span id="order-shipping">20.00 Lei</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold" id="order-total">20.00 Lei</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Stiluri pentru tabelul de produse */
    #products-table input[type="number"] {
        width: 100%;
    }
    tr.product-selected {
        background-color: rgba(0, 123, 255, 0.05);
    }
    tr.product-disabled {
        opacity: 0.5;
    }
    .product-total {
        font-weight: bold;
    }
</style>
@endpush

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Selectăm toate checkbox-urile produselor și inputurile de cantitate
        const productCheckboxes = document.querySelectorAll('.product-checkbox');
        const quantityInputs = document.querySelectorAll('.product-quantity');
        
        // Funcție pentru actualizarea totalului unui produs
        function updateProductTotal(checkbox) {
            const productId = checkbox.value;
            const row = checkbox.closest('tr');
            const quantityInput = row.querySelector('.product-quantity');
            const totalCell = row.querySelector('.product-total');
            
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(quantityInput.value);
                const total = price * quantity;
                
                totalCell.textContent = total.toFixed(2) + ' Lei';
                row.classList.add('product-selected');
                quantityInput.disabled = false;
            } else {
                totalCell.textContent = '0.00 Lei';
                row.classList.remove('product-selected');
                quantityInput.disabled = true;
            }
            
            updateOrderSummary();
        }
        
        // Funcție pentru actualizarea totalului unui produs când se schimbă cantitatea
        function updateQuantityTotal(input) {
            const row = input.closest('tr');
            const checkbox = row.querySelector('.product-checkbox');
            const totalCell = row.querySelector('.product-total');
            
            if (checkbox.checked) {
                const price = parseFloat(checkbox.dataset.price);
                const quantity = parseInt(input.value);
                const total = price * quantity;
                
                totalCell.textContent = total.toFixed(2) + ' Lei';
            }
            
            updateOrderSummary();
        }
        
        // Funcție pentru actualizarea sumarului comenzii
        function updateOrderSummary() {
            let subtotal = 0;
            
            // Parcurgem toate checkbox-urile selectate
            productCheckboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    const quantityInput = row.querySelector('.product-quantity');
                    const price = parseFloat(checkbox.dataset.price);
                    const quantity = parseInt(quantityInput.value);
                    
                    subtotal += price * quantity;
                }
            });
            
            const tax = subtotal * 0.19;
            const shipping = subtotal > 500 ? 0 : 20;
            const total = subtotal + tax + shipping;
            
            document.getElementById('order-subtotal').textContent = subtotal.toFixed(2) + ' Lei';
            document.getElementById('order-tax').textContent = tax.toFixed(2) + ' Lei';
            document.getElementById('order-shipping').textContent = shipping === 0 ? 'Gratuită' : shipping.toFixed(2) + ' Lei';
            document.getElementById('order-total').textContent = total.toFixed(2) + ' Lei';
        }
        
        // Adăugăm event listeners pentru checkbox-uri
        productCheckboxes.forEach(function(checkbox) {
            // Dezactivăm produsele fără stoc
            if (parseInt(checkbox.dataset.stock) <= 0) {
                checkbox.disabled = true;
                checkbox.closest('tr').classList.add('product-disabled');
            }
            
            // Event listener pentru schimbarea stării checkbox-ului
            checkbox.addEventListener('change', function() {
                updateProductTotal(this);
            });
        });
        
        // Adăugăm event listeners pentru inputurile de cantitate
        quantityInputs.forEach(function(input) {
            // Inițializăm inputurile în funcție de starea checkbox-ului
            const checkbox = input.closest('tr').querySelector('.product-checkbox');
            input.disabled = !checkbox.checked;
            
            // Event listener pentru schimbarea cantității - schimbăm la orice modificare
            input.addEventListener('change', function() {
                updateQuantityTotal(this);
            });
            
            // Event listener pentru input direct - se declanșează la fiecare modificare de valoare
            input.addEventListener('input', function() {
                updateQuantityTotal(this);
            });
        });
        
        // Verificăm și actualizăm starea inițială pentru produsele deja selectate
        productCheckboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                updateProductTotal(checkbox);
            }
        });
        
        // Inițializăm sumarul comenzii
        updateOrderSummary();
    });
</script>
@endsection 