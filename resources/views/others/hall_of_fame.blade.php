@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Hall of Fame</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-6">
          			<div class="card">
		              
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span>Top 10 Pembelian Sosial Media</span></h4>
		              	
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Pembelian</th>
								</tr>
								@foreach($top_sosmed as $sosmed)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $sosmed->name }}</td>
									<td>{{ $sosmed->jumlah }} Pembelian ({{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($sosmed->price)}})</td>
								</tr>
								@endforeach
							</table>
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-6">
          			<div class="card">
		              
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span>Top 10 Pembelian Pulsa</span></h4>
		              	
						<div class="table-responsive">
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>Nama</th>
									<th>Pembelian</th>
								</tr>
								@foreach($top_pulsa as $pulsa)
								<tr>
									<td>{{ $loop->iteration }}</td>
									<td>{{ $pulsa->name }}</td>
									<td>{{ $pulsa->jumlah }} Pesanan ({{ config('web_config')['CURRENCY_CODE'] }} {{ Numberize::make($pulsa->price) }})</td>
								</tr>
								@endforeach
								@forelse($top_pulsa as $pulsa)
								@empty
								<tr>
									<td colspan="3" class="text-center">No data</td>
								</tr>
								@endforelse
							</table>
						</div>                
		              </div>
		            </div>
          		</div>
          	</div>

          	
  			<div class="card">
              <div class="card-body">
                <h4 class='header-title mt-0'><span>Top 10 Deposit Tertinggi</span></h4>
              	
				<div class="table-responsive">
					<table class="table table-striped table-md">
						<tr>
							<th>#</th>
							<th>Nama</th>
							<th>Jumlah deposit</th>
						</tr>
						@foreach($top_deposit as $deposit)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $deposit->name }}</td>
							<td>{{ config('web_config')['CURRENCY_CODE'] }} {{ Numberize::make($deposit->total_deposit) }}</td>
						</tr>
						@endforeach
						@forelse($top_deposit as $deposit)
						@empty
						<tr>
							<td colspan="3" class="text-center">No data</td>
						</tr>
						@endforelse
					</table>
				</div>                
              </div>
            </div>
  			<div class="card">
              <div class="card-body">
                <h4 class='header-title mt-0'><span>Top 10 Layanan Sosial Media</span></h4>
              	
				<div class="table-responsive">
					<table class="table table-striped table-md">
						<tr>
							<th>#</th>
							<th>Nama Layanan</th>
							<th>Pembelian</th>
						</tr>
						@foreach($top_layanan as $layanan)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $layanan->name }}</td>
							<td>{{ $layanan->jumlah_order }} Pembelian</td>
						</tr>
						@endforeach
						@forelse($top_layanan as $layanan)
						@empty
						<tr>
							<td colspan="3" class="text-center">No data</td>
						</tr>
						@endforelse
					</table>
				</div>                
              </div>
            </div>
          		
            
          </div>
        </section>




</div>
@endsection