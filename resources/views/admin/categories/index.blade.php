@extends('admin.layout')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Categories Management</h1>
  </div>
  <div class="col-sm-6">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary float-sm-right rounded-0">
        <i class="fas fa-plus mr-1"></i> Add New Category
    </a>
  </div>
</div>
@endsection

@section('content')
<div class="card">
  <div class="card-header bg-dark">
    <h3 class="card-title">NovaStore - Kategori Yönetim Paneli</h3>
  </div>
  <div class="card-body">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> Success!</h5>
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
      <table id="categoryTable" class="table table-bordered table-striped table-hover align-middle">
        <thead>
          <tr>
            <th style="width: 15%;">ID</th>
            <th>Category Name</th>
            <th style="width: 25%;">Created At</th>
          </tr>
        </thead>
        <tbody>
          @forelse($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td><b>{{ $category->name }}</b></td>
              <td>{{ $category->created_at ? \Carbon\Carbon::parse($category->created_at)->format('d/m/Y H:i') : '-' }}</td>
            </tr>
          @empty
            <tr><td>1</td><td><b>Computers</b></td><td>{{ date('d/m/Y H:i') }}</td></tr>
            <tr><td>2</td><td><b>Smartphones</b></td><td>{{ date('d/m/Y H:i') }}</td></tr>
            <tr><td>3</td><td><b>Accessories</b></td><td>{{ date('d/m/Y H:i') }}</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    if ($.fn.DataTable) {
      $("#categoryTable").DataTable({
        "responsive": true, 
        "lengthChange": true, 
        "autoWidth": false, 
        "ordering": true,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#categoryTable_wrapper .col-md-6:eq(0)');
    }
  });
</script>
@endsection