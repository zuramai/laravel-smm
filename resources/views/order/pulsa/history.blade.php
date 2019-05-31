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
		                <h4 class='header-title mt-0'><span>Riwayat Pemesanan Pulsa</span></h4>
		              	<div class="alert alert-info">
		              		<i class="fa fa-globe-asia"></i>: Order melalui web <br>
		              		<i class="fa fa-random"></i>: Order melalui API
		              	</div>
						<div class="form">
								<div class="row">
									<div class="col-md-6 offset-md-6">
											<form method="GET">
												<div class="input-group mb-3">
													<div class="input-group-prepend">
													    <span class="input-group-text" id="basic-addon1"><i class="fa fa-search"></i></span>
													  </div>
													<input type="text" placeholder="Cari target atau id pesanan" class="form-control" name="search">
												</div>
											</form>
									</div>
								</div>
						</div>
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th></th>
									<th>Order ID</th>
									<th>Service</th>
									<th>Target</th>
									<th>Harga</th>
									<th>SN</th>
									<th>Status</th>
									<th>Refund</th>
									
								</tr>
									@foreach($order as $data_order)
									<tr>
										<td><i class="fa fa-{{ ($data_order->place_from == 'WEB' ? 'globe-asia' : 'random') }}"></i></td>
										<td>#{{ $data_order->id }}</td>
										<td>{{ $data_order->service->name }}</td>
										<td>{{ $data_order->data }}</td>
										<td>Rp {{ number_format($data_order->price) }}</td>
										<td>{{ $data_order->sn }}</td>
										
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
		</div>              
    </div>
        
</div>
            



</div>
@endsection