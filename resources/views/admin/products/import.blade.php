@extends('layouts.admin')

@section('title', 'Import Products')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Import Products</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-excel me-2"></i>Import Products from Excel/CSV
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="excel_file" class="form-label">Select File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('excel_file') is-invalid @enderror" 
                               id="excel_file" name="excel_file" accept=".xlsx,.xls,.csv" required>
                        @error('excel_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Supported formats: .xlsx, .xls, .csv (Max size: 10MB)
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Import Options</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="skip_duplicates" name="skip_duplicates" value="1" checked>
                            <label class="form-check-label" for="skip_duplicates">
                                Skip duplicate products (based on name)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="update_existing" name="update_existing" value="1">
                            <label class="form-check-label" for="update_existing">
                                Update existing products if found
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="activate_imported" name="activate_imported" value="1" checked>
                            <label class="form-check-label" for="activate_imported">
                                Set imported products as active
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload me-1"></i>Import Excel
                        </button>
                        <a href="{{ route('admin.products') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>Import Guidelines
                </h5>
            </div>
            <div class="card-body">
                <h6>Required Columns:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i><strong>name</strong> - Product name</li>
                    <li><i class="fas fa-check text-success me-2"></i><strong>description</strong> - Product description</li>
                    <li><i class="fas fa-check text-success me-2"></i><strong>price</strong> - Product price (numeric)</li>
                    <li><i class="fas fa-check text-success me-2"></i><strong>category</strong> - Product category</li>
                    <li><i class="fas fa-check text-success me-2"></i><strong>stock_quantity</strong> - Available stock</li>
                </ul>

                <h6>Optional Columns:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-info text-info me-2"></i><strong>brand</strong> - Product brand</li>
                    <li><i class="fas fa-info text-info me-2"></i><strong>image_url</strong> - Product image URL</li>
                    <li><i class="fas fa-info text-info me-2"></i><strong>tags</strong> - Comma-separated tags</li>
                    <li><i class="fas fa-info text-info me-2"></i><strong>attributes</strong> - JSON attributes</li>
                </ul>

                <hr>

                <h6>Sample Format:</h6>
                <div class="bg-light p-2 rounded">
                    <small class="text-muted">
                        name,description,price,category,brand,stock_quantity<br>
                        "Wireless Headphones","High-quality wireless headphones",129.99,Electronics,TechAudio,50
                    </small>
                </div>

                <hr>

                <h6>Quick Stats:</h6>
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <small class="text-muted">Total Products</small>
                            <div class="fw-bold">{{ \App\Models\Product::count() }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="border rounded p-2">
                            <small class="text-muted">Active Products</small>
                            <div class="fw-bold">{{ \App\Models\Product::where('is_active', true)->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Download Template -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>Download Template
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted small">Download a sample Excel template to get started.</p>
                <a href="#" class="btn btn-outline-primary btn-sm w-100">
                    <i class="fas fa-file-excel me-1"></i>Download Template
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Import History -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>Recent Import History
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>File Name</th>
                                <th>Status</th>
                                <th>Products Imported</th>
                                <th>Errors</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    <i class="fas fa-info-circle me-1"></i>No import history available
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.form-check {
    margin-bottom: 0.5rem;
}
</style>
@endpush 