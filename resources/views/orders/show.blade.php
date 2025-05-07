@extends('layouts.app')

@section('title', 'Detalii Comandă #' . $order->id)

@section('header', 'Detalii Comandă')

@section('breadcrumbs')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
<li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Comenzi</a></li>
<li class="breadcrumb-item active">Detalii Comandă #{{ $order->id }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalii Comandă #{{ $order->id }}</h1>
        <div>
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Editează
            </a>
            <a href="{{ route('orders.export') }}" class="btn btn-sm btn-secondary shadow-sm ml-2">
                <i class="fas fa-download fa-sm text-white-50"></i> Export
            </a>
        </div>
    </div>

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

    <div class="row">
        <!-- Informații Comandă -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Informații Comandă</h6>
                    <span class="badge 
                        @if($order->status == 'pending') bg-warning text-dark
                        @elseif($order->status == 'processing') bg-info
                        @elseif($order->status == 'completed') bg-success
                        @elseif($order->status == 'cancelled') bg-danger
                        @elseif($order->status == 'refunded') bg-dark
                        @endif
                    ">
                        @if($order->status == 'pending') În așteptare
                        @elseif($order->status == 'processing') În procesare
                        @elseif($order->status == 'completed') Finalizată
                        @elseif($order->status == 'cancelled') Anulată
                        @elseif($order->status == 'refunded') Rambursată
                        @endif
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5 class="font-weight-bold mb-3">Informații Client</h5>
                            <p class="mb-1"><strong>Nume:</strong> {{ $order->customer_name }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p class="mb-1"><strong>Telefon:</strong> {{ $order->customer_phone ?? 'N/A' }}</p>
                            <p class="mb-0"><strong>Metodă plată:</strong> {{ $order->payment_method }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5 class="font-weight-bold mb-3">Informații Livrare</h5>
                            <p class="mb-1"><strong>Adresă livrare:</strong> {{ $order->shipping_address }}</p>
                            <p class="mb-1"><strong>Adresă facturare:</strong> {{ $order->billing_address ?? 'Aceeași cu adresa de livrare' }}</p>
                            <p class="mb-1"><strong>Status:</strong> {{ $order->status }}</p>
                            <p class="mb-0"><strong>ID Plată:</strong> {{ $order->payment_id ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <h5 class="font-weight-bold mb-3">Produse Comandate</h5>
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
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="font-weight-bold mb-3">Note Comandă</h5>
                            <div class="p-3 bg-light rounded">
                                {{ $order->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sumar Financiar și Acțiuni -->
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
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Acțiuni</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Editează comanda
                        </a>
                        
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-grid mt-2" id="delete-order-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Șterge comanda
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Istoric Comandă</h6>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">Comandă plasată</h6>
                                <p class="small text-muted">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </li>
                        @if($order->status != 'pending')
                        <li class="timeline-item">
                            <div class="timeline-marker 
                                @if($order->status == 'processing') bg-info
                                @elseif($order->status == 'completed') bg-success
                                @elseif($order->status == 'cancelled') bg-danger
                                @elseif($order->status == 'refunded') bg-dark
                                @endif
                            "></div>
                            <div class="timeline-content">
                                <h6 class="mb-0">
                                    @if($order->status == 'processing') În procesare
                                    @elseif($order->status == 'completed') Finalizată
                                    @elseif($order->status == 'cancelled') Anulată
                                    @elseif($order->status == 'refunded') Rambursată
                                    @endif
                                </h6>
                                <p class="small text-muted">{{ $order->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .timeline {
        list-style: none;
        padding: 0;
        position: relative;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
        left: 12px;
        margin-left: -1px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 15px;
        display: flex;
        align-items: flex-start;
    }
    
    .timeline-marker {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 15px;
    }
    
    .timeline-content {
        flex: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('delete-order-form');
        
        deleteForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const orderId = '{{ $order->id }}';
            const confirmDelete = confirm(`Ești sigur că vrei să ștergi comanda #${orderId}?\n\nDetalii comandă:\n- Client: {{ $order->customer_name }}\n- Total: {{ number_format($order->total, 2) }} Lei\n- Status: {{ $order->status }}\n\nAceastă acțiune nu poate fi anulată!`);
            
            if (confirmDelete) {
                this.submit();
            }
        });
    });
</script>
@endpush 