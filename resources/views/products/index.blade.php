@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Our Products</h1>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Search products..." value="{{ request('q') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-4">
            <a href="{{ route('recommendations') }}" class="btn btn-outline-danger w-100">
                <i class="fas fa-star me-1"></i>View Recommendations
            </a>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3 mb-4">
                <div class="card h-100 product-card">
                    @if($product->image_url)
                        <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-box fa-3x text-muted"></i>
                        </div>
                    @endif
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                        
                        <!-- Sales Performance Metrics -->
                        <div class="mt-auto">
                            <div class="row text-center mb-2">
                                <div class="col-6">
                                    <small class="text-muted d-block">Category</small>
                                    <span class="badge bg-danger">{{ $product->category }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Stock</small>
                                    <span class="badge bg-{{ $product->stock_quantity > 0 ? 'success' : 'danger' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </div>
                            </div>
                            
                            @if(isset($product->total_units_sold))
                                <div class="row text-center">
                                    <div class="col-12">
                                        <small class="text-muted d-block">Units Sold</small>
                                        <strong class="text-success">{{ number_format($product->total_units_sold) }}</strong>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                            <small class="text-muted">
                                <i class="fas fa-store me-1"></i>{{ $product->merchants->count() }} merchants
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-box fa-3x text-muted mb-3"></i>
                    <h4>No products found</h4>
                    <p class="text-muted">Try adjusting your search criteria.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.card-img-top {
    border-bottom: 1px solid #dee2e6;
}
</style>
@endpush 