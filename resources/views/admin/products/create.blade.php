@extends('admin.layout')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Create New Product</h1>
  </div>
</div>
@endsection

@section('content')
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Product Specifications</h3>
  </div>
  <form action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label>Product Name</label>
        <input type="text" name="name" class="form-control rounded-0" placeholder="e.g. MacBook Pro M4" required>
      </div>
      <div class="form-group">
        <label>Price ($)</label>
        <input type="number" step="0.01" name="price" class="form-control rounded-0" placeholder="e.g. 1999.00" required>
      </div>
      <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control rounded-0">
          <option value="1">Computers (ID: 1)</option>
          <option value="2">Smartphones (ID: 2)</option>
          <option value="3">Accessories (ID: 3)</option>
        </select>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea name="description" class="form-control rounded-0" rows="4" placeholder="Enter product details..."></textarea>
      </div>
    </div>
    <div class="card-footer">
      <button type="submit" class="btn btn-success rounded-0 px-4">Save Product</button>
      <a href="{{ route('admin.products.index') }}" class="btn btn-secondary rounded-0">Cancel</a>
    </div>
  </form>
</div>
@endsection