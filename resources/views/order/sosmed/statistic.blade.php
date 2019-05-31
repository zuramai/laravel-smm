@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<section class="section">
          <div class="section-header">
            <h1>New order</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item"><a href="#">Order</a></div>
              <div class="breadcrumb-item"><a href="#">Sosial Media</a></div>
				<div class="breadcrumb-item">Riwayat Pemesanan</div>
            </div>
          </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-12">
          			<div class="card">
		              <div class="">
		                <h4 class='header-title mt-0'><span>Riwayat Pemesanan</span></h4>
		              </div>
		             
		              <div class="card-body">
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
									<th>Total Order</th>
									<th>Orderan Berstatus Success</th>
									<th>Orderan Berstatus Pending</th>
									<th>Orderan Berstatus Partial</th>
									<th>Orderan Berstatus Error</th>
									<th>Orderan Berstatus Processing</th>
									<th>Pesanan dari website</th>
									<th>Pesanan dari API</th>
									<th>Total pengembalian dana</th>
								</tr>
								<tr>
									<td></td>
								</tr>
									
							</table>
						</div>
						<div class="float-right">
							
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-4">
          			
          		</div>
          	</div>
            
          </div>
        </section>




</div>
@endsection