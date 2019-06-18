@extends(Auth::user()->level == "Admin"?'layouts.horizontal':'layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"><i class="dripicons-user"></i> Edit Pesanan</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                    <div class="">
                        </div>
                        <form method="POST" action="">
                            @csrf
                          <div class="card-body">
                            <h4 class='header-title mt-0'><span>Edit Order </span></h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                              <div class="form-group">
                                <label>Order id</label>
                                <input type="text" placeholder="Nama layanan.." class="form-control" name="name" value="{{ $order->id }}" disabled>
                              </div>
                              <div class="form-group">
                                <label>Provider id</label>
                                <input type="text" placeholder="Nama layanan.." class="form-control" name="name" value="{{ $order->poid }}" disabled>
                              </div>
                              <div class="form-group">
                                <label>User</label>
                                <input type="text" value='{{ $order->user->name }}' class="form-control" disabled>
                              </div>
                              <div class="form-group">
                                <label>Service</label>
                                <input type="text" value='{{ $order->service->name }}' class="form-control" disabled>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                    <div class="col">
                                        <label>Start count</label>
                                        <input type="number" name="start" class="form-control" value="{{ $order->start_count }}">
                                    </div>
                                    <div class="col">
                                        <label>Remains</label>
                                        <input type="text" name='remains' value='{{$order->remains}}' class="form-control">
                                    </div>
                                </div>
                                
                              </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="Pending" {{ ($order->status == 'Pending') ? 'selected' : '' }}>Pending</option>
                                    <option value="Processing" {{ ($order->status == 'Processing') ? 'selected' : '' }}>Processing</option>
                                    <option value="Success" {{ ($order->status == 'Success') ? 'selected' : '' }}>Success</option>
                                    <option value="Error" {{ ($order->status == 'Error') ? 'selected' : '' }}>Error</option>
                                    <option value="Partial" {{ ($order->status == 'Partial') ? 'selected' : '' }}>Partial</option>
                                </select>
                            </div>
                              
                              
                          </div>
                          <div class="form-group mr-3 text-right">
                            <button type="submit" class="btn btn-primary">Edit</button>
                          </div>    
                        </form>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
</div>
@endsection