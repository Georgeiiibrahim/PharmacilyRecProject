@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('admin.products.import.form') }}" class="btn btn-sm btn-outline-success">
                <i class="fas fa-file-excel me-1"></i>Import Data
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Products
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($revenueStats['total_revenue'], 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Orders
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($revenueStats['total_orders']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Average Order Value
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">${{ number_format($revenueStats['average_order_value'], 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue by Site -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-globe me-2"></i>Revenue by Site
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Site</th>
                                <th>Total Revenue</th>
                                <th>Orders</th>
                                <th>Units Sold</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siteRevenue as $site)
                                <tr>
                                    <td>{{ $site->name }}</td>
                                    <td>${{ number_format($site->total_revenue ?? 0, 2) }}</td>
                                    <td>{{ number_format($site->order_count ?? 0) }}</td>
                                    <td>{{ number_format($site->total_units ?? 0) }}</td>
                                    <td>${{ $site->order_count > 0 ? number_format($site->total_revenue / $site->order_count, 2) : '0.00' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No site data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Products by Revenue -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-star me-2"></i>Top Products by Revenue
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Total Revenue</th>
                                <th>Orders</th>
                                <th>Units Sold</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($productRevenue as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category }}</td>
                                    <td>${{ number_format($product->total_revenue ?? 0, 2) }}</td>
                                    <td>{{ number_format($product->order_count ?? 0) }}</td>
                                    <td>{{ number_format($product->total_units ?? 0) }}</td>
                                    <td>${{ $product->order_count > 0 ? number_format($product->total_revenue / $product->order_count, 2) : '0.00' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No product data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Revenue Chart -->
@if($revenueStats['monthly_revenue']->count() > 0)
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-area me-2"></i>Monthly Revenue (Last 6 Months)
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Revenue</th>
                                <th>Orders</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueStats['monthly_revenue'] as $month)
                                <tr>
                                    <td>{{ \Carbon\Carbon::createFromDate($month->year, $month->month, 1)->format('F Y') }}</td>
                                    <td>${{ number_format($month->total_revenue, 2) }}</td>
                                    <td>{{ number_format($month->order_count) }}</td>
                                    <td>${{ $month->order_count > 0 ? number_format($month->total_revenue / $month->order_count, 2) : '0.00' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Recent Orders Table -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-history me-2"></i>Recent Orders
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Site</th>
                                <th>Units</th>
                                <th>Region</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Order::with(['customer', 'site'])->latest('order_date')->take(10)->get() as $order)
                                <tr>
                                    <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('M d, Y') : 'N/A' }}</td>
                                    <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                    <td>{{ $order->site->name ?? 'N/A' }}</td>
                                    <td>{{ $order->units }}</td>
                                    <td>{{ $order->region ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tools me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-box me-2"></i>Manage Products
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.merchants') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-store me-2"></i>Manage Merchants
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-users me-2"></i>Manage Users
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('admin.products.import.form') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-file-excel me-2"></i>Import Data
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.font-weight-bold {
    font-weight: 700 !important;
}
.text-xs {
    font-size: 0.7rem;
}
</style>
@endpush 