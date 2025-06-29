@extends('layouts.app')

@section('title', 'Product Recommendations')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-star me-2"></i>Product Recommendations
            </h1>
            <p class="text-muted">Discover products based on sales performance and popularity</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-filter me-2"></i>Filter Recommendations
                    </h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('recommendations') }}" class="row g-3">
                        <div class="col-md-3">
                            <label for="site" class="form-label">Site</label>
                            <select class="form-select" id="site" name="site">
                                <option value="">All Sites</option>
                                @foreach($sites ?? [] as $site)
                                    <option value="{{ $site }}" {{ request('site') == $site ? 'selected' : '' }}>
                                        {{ $site }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="type" class="form-label">Product Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                @foreach($types ?? [] as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="region" class="form-label">Region</label>
                            <select class="form-select" id="region" name="region">
                                <option value="">All Regions</option>
                                @foreach($regions ?? [] as $region)
                                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                                        {{ $region }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('recommendations') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Recommendations -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-fire me-2 text-danger"></i>Top Performing Products
            </h2>
            <div class="row">
                @forelse($recommendations as $product)
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
                                
                                <!-- Sales Metrics -->
                                <div class="mt-auto">
                                    <div class="row text-center mb-2">
                                        <div class="col-6">
                                            <small class="text-muted d-block">Category</small>
                                            <span class="badge bg-danger">{{ $product->category }}</span>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted d-block">Orders</small>
                                            <span class="badge bg-info">{{ $product->order_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row text-center">
                                        <div class="col-12">
                                            <small class="text-muted d-block">Units Sold</small>
                                            <strong class="text-success">{{ number_format($product->total_units_sold ?? 0) }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-danger btn-sm w-100">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h4>No recommendations found</h4>
                            <p class="text-muted">Try adjusting your filters or import some order data.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Popular Products -->
    @if($popularProducts->count() > 0)
        <div class="row mb-5">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-trophy me-2 text-warning"></i>Most Popular Products
                </h2>
                <div class="row">
                    @foreach($popularProducts as $product)
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
                                    
                                    <div class="mt-auto">
                                        <div class="row text-center">
                                            <div class="col-12">
                                                <small class="text-muted d-block">Units Sold</small>
                                                <strong class="text-success">{{ number_format($product->total_units_sold ?? 0) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Trending Products -->
    @if($trendingProducts->count() > 0)
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">
                    <i class="fas fa-trending-up me-2 text-success"></i>Trending Products (Last 30 Days)
                </h2>
                <div class="row">
                    @foreach($trendingProducts as $product)
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
                                    
                                    <div class="mt-auto">
                                        <div class="row text-center">
                                            <div class="col-6">
                                                <small class="text-muted d-block">Recent Sales</small>
                                                <strong class="text-success">{{ number_format($product->recent_units_sold ?? 0) }}</strong>
                                            </div>
                                            <div class="col-6">
                                                <small class="text-muted d-block">Orders</small>
                                                <strong class="text-info">{{ $product->recent_order_count ?? 0 }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-footer bg-transparent">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
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

@push('scripts')
<script>
$(document).ready(function() {
    // Load filter options via AJAX
    $.get('{{ route("recommendations.filter-options") }}')
        .done(function(data) {
            // Populate site options
            var siteSelect = $('#site');
            data.sites.forEach(function(site) {
                siteSelect.append(new Option(site, site));
            });
            
            // Populate type options
            var typeSelect = $('#type');
            data.types.forEach(function(type) {
                typeSelect.append(new Option(type, type));
            });
            
            // Populate region options
            var regionSelect = $('#region');
            data.regions.forEach(function(region) {
                regionSelect.append(new Option(region, region));
            });
        });
});
</script>
@endpush 