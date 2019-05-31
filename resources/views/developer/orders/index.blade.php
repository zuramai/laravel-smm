@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"><i class="dripicons-user"></i> Kelola Pesanan</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          	<div class="row">
          		<div class="col-md-12">
          			<div class="card">
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Semua Pesanan Sosial Media</span></h4>
                    <div class="float-left">
                      <form method="GET">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Cari ID order atau target" name="search">
                          <div class="input-group-append">                                            
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="clearfix mb-3"></div>
		              	@if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    	@endif
                          <div class="table-responsive">
                                <table class="table table-striped table-md">
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Poid</th>
                                    <th>User</th>
                                    <th>Service</th>
                                    <th>Target</th>
                                    <th>Quantity</th>
                                    <th>Start/Remains</th>
                                    <th>Price</th>
                                    <th>Provider</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($orders as $order)
                                <tr>
                                    <td><i class="fa fa-{{ ($order->place_from == 'WEB' ? 'globe-asia' : 'random') }}"></i></td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ date('d F y H:i:s', strtotime($order->created_at)) }}</td>
                                    <td>{{ $order->poid }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->target }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>{{ $order->start_count.'/'.$order->remains }}</td>
                                    <td>Rp {{ $order->price }}</td>
                                    <td>{{ $order->service->provider->name }}</td>
                                    <td><span class="badge badge-{{ ($order->status === 'Pending') ? 'warning' : (($order->status == 'Error' || $order->status == 'Partial') ? 'danger' : (($order->status == 'Processing') ? 'primary' : 'success')) }}">{{ $order->status }}</span></td>
                                    <td style="display: inline-block;">
                                        <a href="{{ url('developer/orders/sosmed/edit/'.$order->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    

                                    </td>
                                </tr>
                                @endforeach
                            </table>
                          </div>
                          {{$orders->links()}}
		              </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection