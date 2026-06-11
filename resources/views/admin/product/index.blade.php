@extends('admin.layout')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Products Management</h1>
  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary float-sm-right rounded-0">
        <i class="fas fa-plus mr-1"></i> Add New Product
    </a>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header bg-dark">
    <h3 class="card-title">All Catalog Products</h3>
  </div>
  <div class="card-body">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
        </div>
    @endif

    <table id="productTable" class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Category</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
          <tr>
            <td>{{ $product->id }}</td>
            <td><b>{{ $product->name }}</b></td>
            <td class="text-success font-weight-bold">${{ number_format($product->price, 2) }}</td>
            <td><span class="badge badge-secondary">Category {{ $product->category_id ?? $product->category ?? '1' }}</span></td>
            <td>{{ Str::limit($product->description, 60) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    $("#productTable").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false, "ordering": true,
      "buttons": ["copy", "csv", "excel", "pdf", "print"]
    }).buttons().container().appendTo('#productTable_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection