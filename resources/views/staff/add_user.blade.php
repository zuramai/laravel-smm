@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Tambah Pengguna</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end page-title-box -->
        <div class="row">
            <div class="col-md-7">
                <div class="card m-b-30">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Tambahkan Pengguna Baru</h4>
                        <form method="POST" action="">
			              	@csrf
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
			                      <label>Level</label>
			                      <select class="form-control select2" id="level" name="level">
			                        <option>Pilih salah satu..</option>
			                        <option value="Member">Member</option>

			                        @if(auth()->user()->level == 'Admin' || auth()->user()->level == 'Developer'  || auth()->user()->level == 'Reseller' )
			                        <option value="Agen">Agen</option>
			                        @endif

			                        @if(auth()->user()->level == 'Admin' || auth()->user()->level == 'Developer')
			                        <option value="Reseller">Reseller</option>
			                        @endif

			                        @if(auth()->user()->level == 'Developer')
			                        <option value="Admin">Admin</option>
			                        @endif
			                      </select>
			                    </div>
				                <div class="form-group">
			                      <label>Nama</label>
			                      <input type="text" name="name" class="form-control"> 
			                    </div>
				                <div class="form-group">
			                      <label>Username</label>
			                      <input type="text" name="username" class="form-control"> 
			                    </div>
				                <div class="form-group">
			                      <label>Email</label>
			                      <input type="email" name="email" class="form-control"> 
			                    </div>
				                <div class="form-group">
			                      <label>Password</label>
			                      <input type="text" name="password" class="form-control"> 
			                    </div>
				                <div class="form-group">
			                      <label>Nomor telepon</label>
			                      <input type="text" name="phone" class="form-control"> 
			                    </div>
			                    <div id="information">
				                    
			                    </div>
				              </div>
				              <div class="text-right">
				                <button type="submit" class="btn btn-primary">Submit</button>
				              </div>
			              </form>

                       

                    </div>
                </div>
            </div>
            <div class="col-md-5">
            	<div class="card">
          				<div class="card-body">
          					<h4 class="mt-0 mb-4 header-title">Bantuan</h4>
          					<ol>
          						<li><b>Harga daftarkan member:</b> {{config('web_config')['CURRENCY_CODE']}} {{ Numberize::make(config('web_config')['ADD_MEMBER_PRICE']) }}<br><b>Bonus saldo: </b>{{config('web_config')['CURRENCY_CODE']}} {{Numberize::make(config('web_config')['MEMBER_BALANCE'])}}</li>
          						<li><b>Harga daftarkan agen:</b> {{config('web_config')['CURRENCY_CODE']}} {{ Numberize::make(config('web_config')['ADD_AGEN_PRICE']) }}<br><b>Bonus saldo: </b>{{config('web_config')['CURRENCY_CODE']}} {{Numberize::make(config('web_config')['AGEN_BALANCE'])}}</li>
          						<li><b>Harga daftarkan reseller:</b> {{config('web_config')['CURRENCY_CODE']}} {{ Numberize::make(config('web_config')['ADD_RESELLER_PRICE']) }}<br><b>Bonus saldo: </b>{{config('web_config')['CURRENCY_CODE']}} {{Numberize::make(config('web_config')['RESELLER_BALANCE'])}}</li>
          						<li><b>Harga daftarkan reseller:</b> {{config('web_config')['CURRENCY_CODE']}} {{ Numberize::make(config('web_config')['ADD_ADMIN_PRICE']) }}<br><b>Bonus saldo: </b>{{config('web_config')['CURRENCY_CODE']}} {{Numberize::make(config('web_config')['ADMIN_BALANCE'])}}</li>
          					</ol>
          				</div>
          			</div>
            </div>
        </div><!-- end row -->
    </div>
</div> 



</div>
@endsection