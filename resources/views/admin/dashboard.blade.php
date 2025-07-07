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

<!-- Visitor Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Visitors
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $visitorStats['total_visitors'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Today's Visitors
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $visitorStats['today_visitors'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">
                            Unique Visitors
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $visitorStats['unique_visitors'] ?? 0 }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-light shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-muted text-uppercase mb-1">
                            Bounce Rate
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $visitorStats['bounce_rate'] ?? 0 }}%</div>
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
                                <th>City</th>
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
                                    <td>{{ $order->city ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Region Analytics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-globe me-2"></i>Revenue by Region
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Region</th>
                                <th>Total Revenue</th>
                                <th>Orders</th>
                                <th>Units Sold</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($regionAnalytics as $region)
                                <tr>
                                    <td>{{ $region->region }}</td>
                                    <td>${{ number_format($region->total_revenue ?? 0, 2) }}</td>
                                    <td>{{ number_format($region->order_count ?? 0) }}</td>
                                    <td>{{ number_format($region->total_units ?? 0) }}</td>
                                    <td>${{ number_format($region->avg_order_value ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No region data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- City Analytics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-city me-2"></i>Revenue by City
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>City</th>
                                <th>Total Revenue</th>
                                <th>Orders</th>
                                <th>Units Sold</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cityAnalytics as $city)
                                <tr>
                                    <td>{{ $city->city }}</td>
                                    <td>${{ number_format($city->total_revenue ?? 0, 2) }}</td>
                                    <td>{{ number_format($city->order_count ?? 0) }}</td>
                                    <td>{{ number_format($city->total_units ?? 0) }}</td>
                                    <td>${{ number_format($city->avg_order_value ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No city data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Method Analytics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-credit-card me-2"></i>Revenue by Payment Method
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Payment Method</th>
                                <th>Total Revenue</th>
                                <th>Orders</th>
                                <th>Units Sold</th>
                                <th>Avg. Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paymentMethodAnalytics as $payment)
                                <tr>
                                    <td>{{ $payment->payment_method }}</td>
                                    <td>${{ number_format($payment->total_revenue ?? 0, 2) }}</td>
                                    <td>{{ number_format($payment->order_count ?? 0) }}</td>
                                    <td>{{ number_format($payment->total_units ?? 0) }}</td>
                                    <td>${{ number_format($payment->avg_order_value ?? 0, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No payment method data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visitor Analytics -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-chart-pie me-2"></i>Top Pages by Visits
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Page</th>
                                <th>Visits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($visitorAnalytics['top_pages'] ?? [] as $page)
                                <tr>
                                    <td>{{ Str::limit($page->page_url, 50) }}</td>
                                    <td>{{ number_format($page->visit_count) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No page data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-desktop me-2"></i>Device Breakdown
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Visitors</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalDeviceVisitors = ($visitorAnalytics['device_stats'] ?? collect())->sum('count');
                            @endphp
                            @forelse($visitorAnalytics['device_stats'] ?? [] as $device)
                                <tr>
                                    <td>
                                        <i class="fas fa-{{ $device->device_type == 'mobile' ? 'mobile-alt' : ($device->device_type == 'tablet' ? 'tablet-alt' : 'desktop') }} me-2"></i>
                                        {{ ucfirst($device->device_type) }}
                                    </td>
                                    <td>{{ number_format($device->count) }}</td>
                                    <td>{{ $totalDeviceVisitors > 0 ? round(($device->count / $totalDeviceVisitors) * 100, 1) : 0 }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No device data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Browser Analytics -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-globe me-2"></i>Browser Analytics
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Browser</th>
                                <th>Visitors</th>
                                <th>Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalBrowserVisitors = ($visitorAnalytics['browser_stats'] ?? collect())->sum('count');
                            @endphp
                            @forelse($visitorAnalytics['browser_stats'] ?? [] as $browser)
                                <tr>
                                    <td>{{ $browser->browser }}</td>
                                    <td>{{ number_format($browser->count) }}</td>
                                    <td>{{ $totalBrowserVisitors > 0 ? round(($browser->count / $totalBrowserVisitors) * 100, 1) : 0 }}%</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No browser data available</td>
                                </tr>
                            @endforelse
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
                    <!-- <div class="col-6 mb-3">
                        <a href="{{ route('admin.merchants') }}" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-store me-2"></i>Manage Merchants
                        </a>
                    </div> -->
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
                    <div class="col-6 mb-3">
                        <button type="button" class="btn btn-outline-warning w-100" onclick="refreshData()">
                            <i class="fas fa-sync-alt me-2"></i>Fresh & Seed
                        </button>
                    </div>
                    <div class="col-6 mb-3">
                        <button type="button" class="btn btn-outline-danger w-100" onclick="seedDatabase()">
                            <i class="fas fa-seedling me-2"></i>Seed Database
                        </button>
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

@push('scripts')
<script>
function refreshData() {
    if (confirm('Are you sure you want to refresh and seed the database? This will drop all tables, recreate them, and populate with sample data (WARNING: This will delete all existing data!).')) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Refreshing & Seeding...';
        
        // Make AJAX request to refresh and seed database
        fetch('{{ route("admin.dashboard.refresh") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Database refreshed and seeded successfully! ' + data.message);
                // Redirect to login page instead of reloading
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    location.reload();
                }
            } else {
                alert('Error refreshing database: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error refreshing database. Please try again.');
        })
        .finally(() => {
            // Restore button state
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}

function seedDatabase() {
    if (confirm('Are you sure you want to seed the database? This will add sample data and may take a moment.')) {
        // Show loading state
        const button = event.target;
        const originalText = button.innerHTML;
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Seeding...';
        
        // Make AJAX request to seed database
        fetch('{{ route("admin.dashboard.seed") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Database seeded successfully! ' + data.message);
                location.reload();
            } else {
                alert('Error seeding database: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error seeding database. Please try again.');
        })
        .finally(() => {
            // Restore button state
            button.disabled = false;
            button.innerHTML = originalText;
        });
    }
}
</script>
@endpush 