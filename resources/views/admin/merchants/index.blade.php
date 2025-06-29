@extends('layouts.admin')

@section('title', 'Merchants Management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Merchants Management</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="#" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-plus me-1"></i>Add Merchant
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-store me-2"></i>All Merchants
        </h5>
    </div>
    <div class="card-body">
        @if($merchants->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Website</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($merchants as $merchant)
                            <tr>
                                <td>{{ $merchant->id }}</td>
                                <td>
                                    <strong>{{ $merchant->name }}</strong>
                                    @if($merchant->address)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($merchant->address, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $merchant->email }}" class="text-decoration-none">
                                        {{ $merchant->email }}
                                    </a>
                                </td>
                                <td>{{ $merchant->phone ?? 'N/A' }}</td>
                                <td>
                                    @if($merchant->website)
                                        <a href="{{ $merchant->website }}" target="_blank" class="text-decoration-none">
                                            <i class="fas fa-external-link-alt me-1"></i>Visit
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $merchant->products->count() }} products</span>
                                </td>
                                <td>
                                    @if($merchant->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $merchants->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-store fa-3x text-muted mb-3"></i>
                <h4>No merchants found</h4>
                <p class="text-muted">Start by adding your first merchant.</p>
                <a href="#" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Add Merchant
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Merchants</h6>
                        <h3 class="mb-0">{{ $merchants->total() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-store fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Active Merchants</h6>
                        <h3 class="mb-0">{{ $merchants->where('is_active', true)->count() }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Products</h6>
                        <h3 class="mb-0">{{ $merchants->sum(function($merchant) { return $merchant->products->count(); }) }}</h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 