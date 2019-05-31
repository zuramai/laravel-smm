@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Voucher</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-7">
          			<div class="card">
                      <form method="POST" action="">
                        @csrf
                          <div class="card-body">
		                      <h4 class='header-title mt-0'><span>Claim Kode Voucher</span></h4>
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
			                <div class="form-group">
		                      <label>Kode voucher</label>
		                      <input type="text" name="code" class="form-control" placeholder="Masukkan kode voucher">
		                    </div>
		                    <div id="information">
			                    
		                    </div>
			              </div>
			              <div class="form-group mr-3 text-right">
			                <button type="submit" class="btn btn-primary">Submit</button>
			              </div>
		              </form>
		            </div>
          		</div>
          		<div class="col-md-5">
          			<div class="card">
                        <div class="card-body">
          					<h4 class='header-title mt-0'><span>Panduan</span></h4>
          					<ol>
          						<li>Kode voucher hanya dapat digunakan satu kali</li>
                      <li>Saldo akan ditambahkan jika submit kode voucher berhasil</li>
          					</ol>
          				</div>
          			</div>
          		</div>
          	</div>		
            
          </div>
    </div>
</div>




</div>
@endsection