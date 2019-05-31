@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
      	<div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Pemesanan Baru</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

        <div class="row">
        	<div class="col-md-7">
                <div class="card m-b-30">
                    <div class="card-body">	
		              <h4 class='header-title mt-0'><span>Order Masal Sosial Media</span></h4>
		              <form method="POST" action="">
		              	@csrf
			              	@if(session('success'))
		                        <div class="alert alert-primary" role="alert">
		                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
		                        </div>
			              	@elseif(session('danger'))
		                        <div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ session('danger') }}
		                        </div>
		                    @endif


		                    @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


		                    <input type="hidden" name="price" id="price">
			                <div class="form-group">
			                	<label>Satu order per baris dalam format</label>
			                	<textarea class="form-control" name="mass" style="height: 200px;" placeholder="service_id|target|jumlah">{{ old('mass') }}</textarea>
			                </div>
			              </div>
			              <div class="form-group mr-3  text-right">
			                <button type="submit" class="btn btn-primary">Submit</button>
			              </div>
		              </form>
	          	</div>
	      	</div>
      		<div class="col-md-5">
      			<div class="card">
      				
      				<div class="card-body">
      					<h4 class='header-title mt-0'><span>Cara Pemesanan</span></h4>
      					<ol>
      						<li>Dapatkan service id di halman <a href="{{url('price/sosmed')}}">Daftar Layanan Sosial Media</a></li>
      						<li>Masukkan format pemesanan yaitu <b>service_id|target|jumlah</b>, contohnya 143|{{config('web_config')['APP_NAME']}}|500</li>
      						<li>Order akan error jika jumlah order melebihi min/max layanan atau id layanan tidak ditemukan</li>
      					</ol>
      				</div>
      			</div>
      		</div>
            
    </div>
</div>


</div>
@endsection