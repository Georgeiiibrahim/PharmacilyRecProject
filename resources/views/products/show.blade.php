@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            @if($product->image_url)
                <img src="{{ $product->image_url }}" class="img-fluid rounded" alt="{{ $product->name }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-box fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="mb-3">
                <span class="badge bg-danger me-2">{{ $product->category }}</span>
            </div>

            <div class="mb-4">
                <p class="text-muted">{{ $product->description }}</p>
            </div>

            <!-- Sales Performance Metrics -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line me-2"></i>Sales Performance
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-success mb-1">
                                    {{ number_format($product->orders->sum('units')) }}
                                </h4>
                                <small class="text-muted">Total Units Sold</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <h4 class="text-warning mb-1">
                                    {{ $product->orders->count() }}
                                </h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-boxes me-2"></i>Availability
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Stock Quantity:</span>
                        <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }} fs-6">
                            {{ $product->stock_quantity }} units
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <span>Status:</span>
                        <span class="badge bg-{{ $product->is_active ? 'success' : 'secondary' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Merchant Information -->
            @if($product->merchants->count() > 0)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-store me-2"></i>Available at {{ $product->merchants->count() }} merchant(s)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($product->merchants as $merchant)
                                <div class="col-6 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-store text-primary me-2"></i>
                                        <span>{{ $merchant->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <a href="{{ route('recommendations') }}" class="btn btn-danger">
                    <i class="fas fa-star me-1"></i>View Similar Products
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left me-1"></i>Back to Products
                </a>
            </div>
        </div>
    </div>


</div>
@endsection

@push('styles')
<style>
.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush 