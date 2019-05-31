@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
      	<div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Riwayat Pemesanan</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

        
      	<div class="row">
      		<div class="col-12">
      			<div class="card">
	              <div class="card-body">
                	<h4 class='header-title mt-0'><span>Riwayat Pemesanan Sosial media</span></h4>
	              	@if(session('success'))
                        <div class="alert alert-primary" role="alert">
                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        </div>
	              	@elseif(session('danger'))
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-exclamation-circle"></i> {{ session('danger') }}
                        </div>
                    @endif
                    @if ($errors->has('quantity'))
	                    	<div class="alert alert-danger" role="alert">
	                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('quantity') }}
	                        </div>
					@endif
					<div class="float-right">
                        <form>
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari order id atau target" name="search">
                            <div class="input-group-append">                                            
                              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                          </div>
                        </form>
                  	</div>				
                  	<div class="clearfix mb-3"></div>
					<div class="table-responsive">
						<table class="table table-striped table-lg">
							<tr>
								<th>ID</th>
								<th>Date</th>
								<th>Service</th>
								<th>Target</th>
								<th>Quantity</th>
								<th>Start/Remains</th>
								<th>Price</th>
								<th>Status</th>
								<th>Refund</th>
							</tr>
								@foreach($order as $data_order)
								<tr>
									<td>#{{ $data_order->id }}</td>
									<td>{{ date('Y-m-d H:i', strtotime($data_order->created_at)) }}</td>
									<td>{{ $data_order->service->name }}</td>
									<td>{{ $data_order->target }}</td>
									<td> {{ $data_order->quantity }}</td>
									<td>{{ $data_order->start_count }}/{{$data_order->remains}}</td>
									<td>Rp {{ number_format($data_order->price) }}</td>
									<td><span class="badge badge-{{ ($data_order->status === 'Pending') ? 'warning' : (($data_order->status == 'Error' || $data_order->status == 'Partial') ? 'danger' : (($data_order->status == 'Processing') ? 'primary' : 'success')) }}">{{ $data_order->status }}</span></td>
									<td>
										<span class="badge badge-{{ ($data_order->refund==0) ? 'danger' : 'success'}}">
											@if($data_order->refund == 0) 
												<i class="fa fa-times"></i>
											@else
												<i class="fa fa-check"></i>
											@endif
										</span>
									</td>
								</tr>
								@endforeach
						</table>
					</div>
					<div class="float-right">
						{{ $order->links() }}
					</div>
						                
	              </div>
	            
	            </div>
      		</div>
      		<div class="col-md-4">
      			
      		</div>
      	</div>
            
    </div>
</div>




</div>
@endsection