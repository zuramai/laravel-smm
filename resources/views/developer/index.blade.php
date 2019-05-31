@extends('layouts.horizontal-developer')
@section('content')
<div class="container-fluid">
<div class="container-fluid">
    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="page-title m-0">Developer Page</h4>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
	<div class="row">
	    <div class="col-xl-3 col-md-6">
	        <div class="card bg-primary mini-stat text-white">
	            <div class="p-3 mini-stat-desc">
	                <div class="clearfix">
	                    <h6 class="text-uppercase mt-0 float-left text-white-50">Order bulan ini</h6>
	                    <h4 class="mb-3 mt-0 float-right">{{$order_sosmed_thismo[0]->total_order}}</h4>
	                </div>
	                <div>
	                	<span>Sosial Media</span>
	                </div>
	                
	            </div>
	            <div class="p-3">
	                <div class="float-right">
	                    <a href="#" class="text-white-50"><i class="mdi mdi-cube-outline h5"></i></a>
	                </div>
	                <p class="font-14 m-0">Bulan lalu : {{$order_sosmed_thismo['lastmo'
	                ]}}</p>
	            </div>
	        </div>
	    </div>

	    <div class="col-xl-3 col-md-6">
	        <div class="card bg-info mini-stat text-white">
	            <div class="p-3 mini-stat-desc">
	                <div class="clearfix">
	                    <h6 class="text-uppercase mt-0 float-left text-white-50">Order bulan ini</h6>
	                    <h4 class="mb-3 mt-0 float-right">{{$order_pulsa_thismo[0]->total_order}} </h4>
	                </div>
	                <div>
	                    <a href=" url('balance_usage') " class="text-white">Pulsa</a>
	                </div>
	            </div>
	            <div class="p-3">
	                <div class="float-right">
	                    <a href="#" class="text-white-50"><i class="mdi mdi-buffer h5"></i></a>
	                </div>
	                <p class="font-14 m-0">Bulan lalu: {{$order_pulsa_thismo['lastmo']}}</p>
	                
	            </div>
	        </div>
	    </div>
	    <div class="col-xl-3 col-md-6">
	        <div class="card bg-pink mini-stat text-white">
	            <div class="p-3 mini-stat-desc">
	                <div class="clearfix">
	                    <h6 class="text-uppercase mt-0 float-left text-white-50">Member Aktif</h6>
	                    <h4 class="mb-3 mt-0 float-right">{{number_format($member['active'])}}</h4>
	                </div>
	                <div>
	                    <span>Pendaftar bulan ini: {{ $member['register_thismo'] }}</span>
	                </div>
	            </div>
	            <div class="p-3">
	                <div class="float-right">
	                    <a href="#" class="text-white-50"><i class="mdi mdi-tag-text-outline h5"></i></a>
	                </div>
	                @if(empty($last_used_balance->created_at))
	                <p class="font-14 m-0">Total saldo: Rp {{ number_format($member['total_saldo']->balance) }}</p>
	                @else
	                <p class="font-14 m-0">Terakhir penggunaan: Rp number_format($last_used_balance->quantity)</p>
	                @endif
	            </div>
	        </div>
	    </div>

	    <div class="col-xl-3 col-md-6">
	        <div class="card bg-success mini-stat text-white">
	            <div class="p-3 mini-stat-desc">
	                <div class="clearfix">
	                    <h6 class="text-uppercase mt-0 float-left text-white-50">Keuntungan</h6>
	                    <h4 class="mb-3 mt-0 float-right">Rp {{ number_format($order_pulsa_alltime['keuntungan']->keuntungan + $order_sosmed_alltime[0]->keuntungan) }}</h4>
	                </div>
	                <div>
	                    <span class=""> Total keuntungan sosmed & pulsa </span> 
	                </div>
	            </div>
	            <div class="p-3">
	                <div class="float-right">
	                    <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
	                </div>
	                <p class="font-14 m-0">Bulan ini: {{number_format($order_pulsa_thismo[0]->keuntungan)}}</p>
	            </div>
	        </div>
	    </div>
	</div>  
	<!-- end row -->
	<div class="row">
		<div class="col-md-4">
  			<div class="card">
                <div class="card-body">
	                <h4 class='header-title mt-0'><span>Statistik Sosmed</span></h4>
	                <div class="mb-2">Bulan Ini:</div>
	                <div class="table-responsive mb-3">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Total Order:</td>
	                			<td>{{ number_format($order_sosmed_thismo[0]->total_order) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Nominal Order:</td>
	                			<td>Rp {{ number_format($order_sosmed_thismo[0]->total_price) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Keuntungan:</td>
	                			<td>Rp {{ number_format($order_sosmed_thismo['keuntungan']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Refund:</td>
	                			<td>Rp {{ number_format($order_sosmed_thismo['refund']->quantity) }}</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="mb-2">Semua Waktu:</div>
	                <div class="table-responsive">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Total Order:</td>
	                			<td>{{ number_format($order_sosmed_alltime[0]->total_order) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Nominal Order:</td>
	                			<td>Rp {{ number_format($order_sosmed_alltime[0]->total_price) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Keuntungan:</td>
	                			<td>Rp {{ number_format($order_sosmed_alltime['keuntungan']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Layanan:</td>
	                			<td>{{ number_format($services['sosmed']['total']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Pending:</td>
	                			<td>{{ number_format($order_sosmed_alltime['pending']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Success:</td>
	                			<td>{{ number_format($order_sosmed_alltime['success']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Processing:</td>
	                			<td>{{ number_format($order_sosmed_alltime['processing']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Error/Partial:</td>
	                			<td>{{ number_format($order_sosmed_alltime['error']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Refund:</td>
	                			<td>Rp {{ number_format($order_sosmed_alltime['refund']->quantity) }}</td>
	                		</tr>
	                	</table>
	                </div>
            	</div>
            </div>
		</div>
		<div class="col-md-4">
  			<div class="card">
                <div class="card-body">
	                <h4 class='header-title mt-0'><span>Statistik Pulsa</span></h4>
	                <div class="mb-2">Bulan Ini:</div>
	                <div class="table-responsive mb-3">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Total Order:</td>
	                			<td>{{ number_format($order_pulsa_thismo[0]->total_order) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Nominal Order:</td>
	                			<td>Rp {{ number_format($order_pulsa_thismo[0]->total_price) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Keuntungan:</td>
	                			<td>Rp {{ number_format($order_pulsa_thismo['keuntungan']->keuntungan) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Refund:</td>
	                			<td>Rp {{ number_format($order_pulsa_thismo['refund']->price) }}</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="mb-2">Semua Waktu:</div>
	                <div class="table-responsive">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Total Order:</td>
	                			<td>{{ number_format($order_pulsa_alltime[0]->total_order) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Nominal Order:</td>
	                			<td>Rp {{ number_format($order_pulsa_alltime[0]->total_price) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Keuntungan:</td>
	                			<td>Rp {{ number_format($order_pulsa_alltime['keuntungan']->keuntungan) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Layanan:</td>
	                			<td>{{ number_format($services['pulsa']['total']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Pending:</td>
	                			<td>{{ number_format($order_pulsa_alltime['pending']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Success:</td>
	                			<td>{{ number_format($order_pulsa_alltime['success']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Order Error/Partial:</td>
	                			<td>{{ number_format($order_pulsa_alltime['error']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Refund:</td>
	                			<td>Rp {{ number_format($order_pulsa_thismo['refund']->price) }}</td>
	                		</tr>
	                	</table>
	                </div>
            	</div>
            </div>
		</div>
		<div class="col-md-4">
  			<div class="card">
                <div class="card-body">
	                <h4 class='header-title mt-0'><span>Statistik Pengguna</span></h4>
	                <div class="mb-2">Bulan Ini:</div>
	                <div class="table-responsive mb-3">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Pendaftar baru:</td>
	                			<td>{{ number_format($member['register_thismo']) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Total Penggunaan Saldo:</td>
	                			<td>Rp {{ number_format($member['penggunaan_saldo']->quantity) }}</td>
	                		</tr>
	                	</table>
	                </div>
	                <div class="mb-2">Semua Waktu:</div>
	                <div class="table-responsive">
	                	<table class="table table-bordered">
	                		<tr>
	                			<td>Total Seluruh Saldo:</td>
	                			<td>Rp {{ number_format($member['balance_total']->balance) }}</td>
	                		</tr>
	                		<tr>
	                			<td>Jumlah Pengguna:</td>
	                			<td>{{ number_format($member['count']) }}</td>
	                		</tr>
	                	</table>
	                </div>
            	</div>
            </div>
		</div>
	</div>		
</div>
</div>
@endsection