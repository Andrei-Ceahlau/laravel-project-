@extends('layouts.app')

@section('title', 'Coș de cumpărături')

@section('header', 'Coș de cumpărături')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Coș de cumpărături</li>
@endsection

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <h1 class="h3 mb-4 text-gray-800">Coș de cumpărături</h1>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Produse în coș</h6>
                </div>
                <div class="card-body">
                    @if(count($products) > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Produs</th>
                                    <th>Preț</th>
                                    <th>Cantitate</th>
                                    <th>Subtotal</th>
                                    <th>Acțiuni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                <tr>
                                    <td>
                                        @if($product['image'])
                                        <img src="{{ asset('storage/' . $product['image']) }}" alt="{{ $product['name'] }}" class="img-thumbnail" style="max-width: 50px;">
                                        @else
                                        <img src="https://via.placeholder.com/50" alt="{{ $product['name'] }}" class="img-thumbnail">
                                        @endif
                                    </td>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ number_format($product['price'], 2) }} Lei</td>
                                    <td>
                                        <form action="{{ route('cart.update', $product['id']) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            <input type="number" name="quantity" value="{{ $product['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>{{ number_format($product['subtotal'], 2) }} Lei</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $product['id']) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Continuă cumpărăturile
                        </a>
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fas fa-trash me-2"></i>Golește coșul
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info">
                        Coșul tău este gol. <a href="{{ route('products.index') }}">Continuă cumpărăturile</a>.
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Sumar comandă</h6>
                </div>
                <div class="card-body">
                    @if(count($products) > 0)
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>{{ number_format($cartTotal, 2) }} Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>TVA (19%):</span>
                        <span>{{ number_format($cartTotal * 0.19, 2) }} Lei</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Livrare:</span>
                        <span>{{ $cartTotal > 500 ? 'Gratuită' : '20.00 Lei' }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold">{{ number_format($cartTotal + ($cartTotal * 0.19) + ($cartTotal > 500 ? 0 : 20), 2) }} Lei</span>
                    </div>
                    
                    <form action="{{ route('cart.checkout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Nume complet</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer_phone" class="form-label">Telefon</label>
                            <input type="text" class="form-control" id="customer_phone" name="customer_phone">
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Adresa de livrare</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Metodă de plată</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="card">Card bancar</option>
                                <option value="transfer bancar">Transfer bancar</option>
                                <option value="ramburs">Plată la livrare (ramburs)</option>
                                <option value="PayPal">PayPal</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Note comandă</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check me-2"></i>Finalizează comanda
                            </button>
                        </div>
                    </form>
                    @else
                    <div class="alert alert-info mb-0">
                        Adaugă produse în coș pentru a plasa o comandă.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 