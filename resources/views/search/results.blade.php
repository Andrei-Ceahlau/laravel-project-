@extends('layouts.app')

@section('title', 'Rezultate căutare: ' . $query)

@section('header', 'Rezultate căutare')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item active">Rezultate căutare</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Rezultate pentru: "{{ $query }}"</h1>
        <div>
            <a href="{{ url()->previous() }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Înapoi
            </a>
        </div>
    </div>

    @if($totalResults == 0)
    <div class="alert alert-info">
        <i class="fas fa-info-circle me-2"></i> Nu am găsit niciun rezultat pentru "{{ $query }}". Încercați să căutați alt termen.
    </div>
    @else
    <div class="alert alert-success">
        <i class="fas fa-check-circle me-2"></i> Am găsit {{ $totalResults }} rezultate pentru "{{ $query }}".
    </div>
    @endif

    <!-- Produse găsite -->
    @if($products->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shopping-cart me-2"></i> Produse ({{ $products->count() }})
            </h6>
            <a href="{{ route('products.index', ['search' => $query]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list fa-sm text-white-50 me-1"></i> Vezi toate
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Produs</th>
                            <th>Categorie</th>
                            <th>Preț</th>
                            <th>Stoc</th>
                            <th>Status</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail me-2" style="max-width: 50px;">
                                    @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" style="width: 50px; height: 50px;">
                                        <i class="fas fa-image text-secondary"></i>
                                    </div>
                                    @endif
                                    <span class="fw-bold">{{ $product->name }}</span>
                                </div>
                            </td>
                            <td>{{ $product->category }}</td>
                            <td>{{ number_format($product->price, 2) }} Lei</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->status == 'in_stock')
                                <span class="badge bg-success">În stoc</span>
                                @elseif($product->status == 'low_stock')
                                <span class="badge bg-warning text-dark">Stoc redus</span>
                                @else
                                <span class="badge bg-danger">Stoc epuizat</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-shopping-cart"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Comenzi găsite -->
    @if($orders->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-invoice me-2"></i> Comenzi ({{ $orders->count() }})
            </h6>
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-list fa-sm text-white-50 me-1"></i> Vezi toate
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Produse</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-bold">{{ $order->customer_name }}</span>
                                    <small>{{ $order->customer_email }}</small>
                                </div>
                            </td>
                            <td>{{ $order->products->count() }} produse</td>
                            <td class="fw-bold">{{ number_format($order->total, 2) }} Lei</td>
                            <td>
                                @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">În așteptare</span>
                                @elseif($order->status == 'processing')
                                <span class="badge bg-info">În procesare</span>
                                @elseif($order->status == 'completed')
                                <span class="badge bg-success">Finalizată</span>
                                @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Anulată</span>
                                @elseif($order->status == 'refunded')
                                <span class="badge bg-dark">Rambursată</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 