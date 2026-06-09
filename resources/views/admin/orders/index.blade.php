@extends('admin.layout')

@section('header')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0">Orders Management</h1>
  </div>
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
      <li class="breadcrumb-item active">Orders</li>
    </ol>
  </div>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header bg-dark">
        <h3 class="card-title">All Customer Orders</h3>
      </div>
      <div class="card-body">
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('success') }}
            </div>
        @endif

        <table id="example1" class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Total Price</th>
              <th>Order Status</th>
              <th>Order Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)
              <tr>
                <td>{{ $order->id }}</td>
                <td><b>{{ $order->name }}</b></td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->phone ?? '-' }}</td>
                <td class="text-success font-weight-bold">${{ number_format($order->total, 2) }}</td>
                <td>
                  @if($order->status == 'New')
                    <span class="badge badge-info text-uppercase p-2">New</span>
                  @elseif($order->status == 'Accepted')
                    <span class="badge badge-primary text-uppercase p-2">Accepted</span>
                  @elseif($order->status == 'Cancelled')
                    <span class="badge badge-danger text-uppercase p-2">Cancelled</span>
                  @elseif($order->status == 'Onshipping')
                    <span class="badge badge-warning text-uppercase p-2">Onshipping</span>
                  @else
                    <span class="badge badge-success text-uppercase p-2">Completed</span>
                  @endif
                </td>
                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '-' }}</td>
                <td class="text-center">
                  <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info btn-flat">
                    <i class="fas fa-eye"></i> Show Details
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  $(function () {
    // Tabloyu akıllı hale getiren, arama kutusunu ve excel butonlarını ekleyen sihirli tetikleyici
    $("#example1").DataTable({
      "responsive": true, 
      "lengthChange": true, 
      "autoWidth": false,
      "ordering": true,
      "order": [[0, "desc"]], // En yeni siparişi en üstte gösterir kanka
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
@endsection