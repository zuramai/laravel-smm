@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
  <div class="col-sm-12">
      <div class="page-title-box">
          <div class="row align-items-center">
              <div class="col-md-8">
                  <h4 class="page-title m-0">Voucher Saldo</h4>
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
                  <h4 class="header-title mt-0"><span>Buat Kode Voucher baru</span></h4>
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
                      <input type="text" name="code" class="form-control" placeholder="Kosongkan untuk kode acak">
                    </div>
	                <div class="form-group">
                      <label>Nominal saldo</label>
                      <input type="number" name="quantity" class="form-control" placeholder="Jumlah saldo yang didapatkan"> 
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
                <h4 class="header-title mt-0"><span>Panduan</span></h4>
      					<ol>
      						<li>Minimal nominal voucher adalah Rp {{number_format(config('web_config')['MIN_VOUCHER'])}}</li>
      						<li>Saldo anda akan di potong sesuai nominal voucher</li>
      						<li>Saldo tidak akan dikembalikan jika menghapus voucher yang masih tersedia</li>
      					</ol>
      				</div>
      			</div>
      		</div>
      	</div>
      	<div class="row">
      		<div class="col-12">
      			<div class="card">
              <div class="card-body">
      					<h4 class='header-title mt-0'>Daftar Kode</h4>
      					<div class="table-responsive">
      						<table class="table table-striped">
      							<thead>
      								<tr>
      									<th>#</th>
      									<th>Kode</th>
      									<th>Nominal</th>
      									<th>Status</th>
      									<th>Action</th>
      								</tr>
      							</thead>
      							<tbody>
      								@foreach($vouchers as $voucher)
      								<tr>
      									<td>{{ $loop->iteration  }}</td>
      									<td>{{ $voucher->code }}</td>
      									<td>Rp {{ number_format($voucher->quantity) }}</td>
      									<td>
      										<span class="badge badge-{{ $voucher->status == 'Available' ? 'success' : 'danger' }}">{{ $voucher->status }}</span>
      									</td>
      									<td>
      										<form method="POST">
      											@method('delete')
      											@csrf
      											<input type="hidden" name="id" value="{{$voucher->id}}">
      											<button type="button" class="btn btn-danger btn-md"><i class="fa fa-trash"></i></button>
      										</form>
      									</td>
      								</tr>
      								@endforeach
      							</tbody>
      						</table>
      					</div>
      				</div>
      			</div>
      		</div>
      	</div>			
        
      
  </div>
</div>




</div>
@endsection