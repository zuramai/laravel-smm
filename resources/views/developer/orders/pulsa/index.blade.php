@extends(Auth::user()->level == "Admin"?'layouts.horizontal':'layouts.horizontal-developer')

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
		              <div class="">
                  </div>
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Kelola Pesanan Pulsa</span></h4>
                    <div class="float-left">
                          <form method="GET">
                            <div class="input-group">
                              <input type="text" class="form-control" placeholder="Cari ID order atau nomor tujuan" name="search">
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
                                    <th>Tanggal</th>
                                    <th>POID</th>
                                    <th>User</th>
                                    <th>Layanan</th>
                                    <th>Harga</th>
                                    <th>Target</th>
                                    <th>SN</th>
                                    <th>Status</th>
                                    <th>Refund</th>
                                    <th>Action</th>
                                </tr>
                                @foreach($orders as $order)
                                <tr>
                                    <td><i class="fa fa-{{ ($order->place_from == 'WEB' ? 'globe-asia' : 'random') }}"></i></td>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ date('d F Y H:i:s',strtotime($order->created_at)) }}</td>
                                    <td>{{ $order->poid }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->service->name }}</td>
                                    <td>{{ $order->price }}</td>
                                    <td>{{ $order->data }}</td>
                                    <td>{{ $order->sn }}</td>
                                    <td><span class="badge badge-{{ ($order->status === 'Pending') ? 'warning' : (($order->status == 'Error' || $order->status == 'Partial') ? 'danger' : (($order->status == 'Processing') ? 'primary' : 'success')) }}">{{ $order->status }}</span></td>
                                    <td>
                                      <span class="badge badge-{{ ($order->refund==0) ? 'danger' : 'success'}}">
                                      @if($order->refund == 0) 
                                        <i class="fa fa-times"></i>
                                      @else
                                        <i class="fa fa-check"></i>
                                      @endif
                                    </span>
                                    </td>
                                    <td style="display: inline-block;">
                                        <a href="{{ url('developer/orders/pulsa/edit/'.$order->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    

                                    </td>
                                </tr>
                                @endforeach
                            </table>
                          </div>
		              </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection