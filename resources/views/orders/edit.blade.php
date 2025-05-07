@extends('layouts.app')

@section('title', 'Editare Comandă #' . $order->id)

@section('header', 'Editare Comandă')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Comenzi</a></li>
<li class="breadcrumb-item"><a href="{{ route('orders.show', $order->id) }}">Comandă #{{ $order->id }}</a></li>
<li class="breadcrumb-item active">Editare</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editare Comandă #{{ $order->id }}</h1>
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
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Detalii Client -->
                        <div class="mb-4">
                            <h5 class="mb-3">Informații Client</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_name" class="form-label">Nume Complet</label>
                                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                                    @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="customer_email" class="form-label">Email</label>
                                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}" required>
                                    @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="customer_phone" class="form-label">Telefon</label>
                                    <input type="text" class="form-control @error('customer_phone') is-invalid @enderror" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}">
                                    @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="payment_method" class="form-label">Metodă de Plată</label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="card" {{ old('payment_method', $order->payment_method) == 'card' ? 'selected' : '' }}>Card bancar</option>
                                        <option value="transfer bancar" {{ old('payment_method', $order->payment_method) == 'transfer bancar' ? 'selected' : '' }}>Transfer bancar</option>
                                        <option value="ramburs" {{ old('payment_method', $order->payment_method) == 'ramburs' ? 'selected' : '' }}>Plată la livrare (ramburs)</option>
                                        <option value="PayPal" {{ old('payment_method', $order->payment_method) == 'PayPal' ? 'selected' : '' }}>PayPal</option>
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
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                                @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="billing_address" class="form-label">Adresa de Facturare (dacă diferă)</label>
                                <textarea class="form-control @error('billing_address') is-invalid @enderror" id="billing_address" name="billing_address" rows="3">{{ old('billing_address', $order->billing_address) }}</textarea>
                                @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Status Comandă -->
                        <div class="mb-4">
                            <h5 class="mb-3">Status Comandă</h5>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>În așteptare</option>
                                    <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>În procesare</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Finalizată</option>
                                    <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Anulată</option>
                                    <option value="refunded" {{ old('status', $order->status) == 'refunded' ? 'selected' : '' }}>Rambursată</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Produse -->
                        <div class="mb-4">
                            <h5 class="mb-3">Produse Comandate</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Produs</th>
                                            <th>Preț</th>
                                            <th>Cantitate</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail me-2" style="max-width: 50px;">
                                                    @else
                                                    <img src="https://via.placeholder.com/50" alt="{{ $product->name }}" class="img-thumbnail me-2">
                                                    @endif
                                                    <span>{{ $product->name }}</span>
                                                </div>
                                            </td>
                                            <td>{{ number_format($product->pivot->price, 2) }} Lei</td>
                                            <td>{{ $product->pivot->quantity }}</td>
                                            <td>{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }} Lei</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i> Pentru a modifica produsele comandate, vă rugăm să creați o nouă comandă.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Note Comandă -->
                        <div class="mb-4">
                            <h5 class="mb-3">Informații Suplimentare</h5>
                            <div class="mb-3">
                                <label for="notes" class="form-label">Note Comandă</label>
                                <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $order->notes) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary me-md-2">Anulează</a>
                            <button type="submit" class="btn btn-primary">Salvează Modificările</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sumar Financiar</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>{{ number_format($order->subtotal, 2) }} Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>TVA (19%):</span>
                        <span>{{ number_format($order->tax, 2) }} Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livrare:</span>
                        <span>{{ $order->shipping > 0 ? number_format($order->shipping, 2) . ' Lei' : 'Gratuită' }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Discount:</span>
                        <span>-{{ number_format($order->discount, 2) }} Lei</span>
                    </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5 mb-0">Total:</span>
                        <span class="h5 mb-0 text-primary">{{ number_format($order->total, 2) }} Lei</span>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i> Valorile financiare nu pot fi modificate direct. Acestea sunt calculate automat pe baza produselor comandate.
                    </div>
                </div>
            </div>
            
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acțiuni Rapide</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid">
                        <button type="button" class="btn btn-success mb-2" onclick="document.getElementById('status').value='completed'; document.getElementById('status').dispatchEvent(new Event('change'));">
                            <i class="fas fa-check-circle me-2"></i>Marchează ca Finalizată
                        </button>
                        <button type="button" class="btn btn-warning mb-2" onclick="document.getElementById('status').value='processing'; document.getElementById('status').dispatchEvent(new Event('change'));">
                            <i class="fas fa-shipping-fast me-2"></i>Marchează în Procesare
                        </button>
                        <button type="button" class="btn btn-danger" onclick="document.getElementById('status').value='cancelled'; document.getElementById('status').dispatchEvent(new Event('change'));">
                            <i class="fas fa-ban me-2"></i>Marchează ca Anulată
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 