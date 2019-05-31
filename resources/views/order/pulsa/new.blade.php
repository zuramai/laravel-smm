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
      		<div class="col-md-7">
      			<div class="card">
	              
	              <form method="POST" action="">
	              	@csrf
		              <div class="card-body">
	                	<h4 class='header-title mt-0'><span>Pulsa & PPOB</span></h4>
		              	@if(session('success'))
	                        <div class="alert alert-primary" role="alert">
	                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
	                        </div>
		              	@elseif(session('danger'))
	                        <div class="alert alert-danger" role="alert">
	                            <i class="fa fa-exclamation-circle"></i> {!! session('danger') !!}
	                        </div>
	                    @endif
	                    @if ($errors->has('quantity'))
		                    	<div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('quantity') }}
		                        </div>
						@endif
		                <div class="form-group">
	                      <label>Kategori</label>
	                      <select class="form-control select2" id="category_pulsa">
	                        <option>Pilih salah satu..</option>
	                        @foreach($cat as $data_category)
	                        	<option value="{{ $data_category->id }}">{{ $data_category->name }}</option>
	                        @endforeach
	                      </select>
	                    </div>
		                <div class="form-group">
	                      <label>Operator</label>
	                      <select class="form-control select2" id="operator_pulsa" name="service">
	                        <option value="">Pilih kategori terlebih dahulu</option>
	                      </select>
	                    </div>
		                <div class="form-group">
	                      <label>Layanan</label>
	                      <select class="form-control select2" id="service_pulsa" name="service">
	                        <option value="">Pilih operator terlebih dahulu</option>
	                      </select>
	                    </div>
	                    <div id="information">
		                    
	                    </div>
		                <div class="form-group">
	                      <label>Nomor telepon tujuan 	</label>
	                      <input type="text" class="form-control" name="target" id="tujuan">
	                    </div>
	                    <div class="form-group" id='pln' style='display:none'>
	                      <label>Nomor Meter PLN 	</label>
	                      <input type="text" class="form-control" name="pln" id="plninput">
	                    </div>
	                    
	                    <input type="hidden" name="price" id="price">
		                <div class="form-group">
	                      <label>Total Price</label>
	                      <input type="number" class="form-control" id="total" readonly >
	                    </div>
		              </div>
		              <div class="mr-3 form-group text-right">
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
      						<li>Pilih kategori terlebih dahulu</li>
      						<li>Pilih layanan yang ingin digunakan</li>
      						<li>Masukkan target sesuai aturan. Instagram followers menggunakan username, Selengkapnya: <a href="">Cara memasukkan target</a></li>
      						<li>Masukkan jumlah yang ingin dipesan</li>
      						<li>Tekan tombol submit dan pesanan anda akan segera diproses</li>
      					</ol>
      				</div>
      			</div>
      		</div>
      	</div>
            
  	</div>
</div>





</div>
@endsection