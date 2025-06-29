@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h2 mb-3">
                <i class="fas fa-search me-2"></i>Search Results
            </h1>
            @if($query || $category || $brand)
                <p class="text-muted">
                    @if($query)
                        Searching for: <strong>"{{ $query }}"</strong>
                    @endif
                    @if($category)
                        @if($query) | @endif Category: <strong>{{ $category }}</strong>
                    @endif
                    @if($brand)
                        @if($query || $category) | @endif Brand: <strong>{{ $brand }}</strong>
                    @endif
                </p>
            @endif
        </div>
    </div>

    <!-- Search Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.search') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="q" class="form-label">Search</label>
                            <input type="text" class="form-control" id="q" name="q" value="{{ $query }}" placeholder="Search products...">
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">All Categories</option>
                                <option value="Electronics" {{ $category == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Clothing" {{ $category == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="Home & Garden" {{ $category == 'Home & Garden' ? 'selected' : '' }}>Home & Garden</option>
                                <option value="Sports & Fitness" {{ $category == 'Sports & Fitness' ? 'selected' : '' }}>Sports & Fitness</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="brand" class="form-label">Brand</label>
                            <select class="form-select" id="brand" name="brand">
                                <option value="">All Brands</option>
                                <option value="TechAudio" {{ $brand == 'TechAudio' ? 'selected' : '' }}>TechAudio</option>
                                <option value="FitTech" {{ $brand == 'FitTech' ? 'selected' : '' }}>FitTech</option>
                                <option value="EcoWear" {{ $brand == 'EcoWear' ? 'selected' : '' }}>EcoWear</option>
                                <option value="HydroLife" {{ $brand == 'HydroLife' ? 'selected' : '' }}>HydroLife</option>
                                <option value="PhotoPro" {{ $brand == 'PhotoPro' ? 'selected' : '' }}>PhotoPro</option>
                                <option value="YogaLife" {{ $brand == 'YogaLife' ? 'selected' : '' }}>YogaLife</option>
                                <option value="ChargeTech" {{ $brand == 'ChargeTech' ? 'selected' : '' }}>ChargeTech</option>
                                <option value="AromaSense" {{ $brand == 'AromaSense' ? 'selected' : '' }}>AromaSense</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Results Summary -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0">
                    Found <strong>{{ $products->total() }}</strong> product(s)
                    @if($products->hasPages())
                        showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }}
                    @endif
                </p>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-times me-1"></i>Clear Filters
                </a>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100" data-product-id="{{ $product->id }}">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-secondary">{{ $product->category }}</span>
                            </div>
                            @if($product->brand)
                                <small class="text-muted">Brand: {{ $product->brand }}</small>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm w-100">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4>No products found</h4>
            <p class="text-muted">
                @if($query || $category || $brand)
                    Try adjusting your search criteria or browse all products.
                @else
                    No products available at the moment.
                @endif
            </p>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-box me-1"></i>Browse All Products
                </a>
                @if($query || $category || $brand)
                    <a href="{{ route('products.search') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear Search
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Track product views when cards are clicked
    $('.product-card').on('click', function() {
        var productId = $(this).data('product-id');
        if (productId) {
            $.post('/track-interaction/' + productId, {
                type: 'view',
                _token: '{{ csrf_token() }}'
            });
        }
    });
});
</script>
@endpush 