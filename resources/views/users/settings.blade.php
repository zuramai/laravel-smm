@extends('layouts.horizontal')
@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Settings</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-7">
          			<div class="card">
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span>Profile</span></h4>
		              	@if(session('danger'))
	                        <div class="alert alert-danger" role="alert">
	                            <i class="fa fa-exclamation-circle"></i> {{ session('danger') }}
	                        </div>
	                    @endif
	                    @if ($errors->has('name'))
		                    	<div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('name') }}
		                        </div>
						@endif
	                    @if ($errors->has('phone'))
		                    	<div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('phone') }}
		                        </div>
						@endif

						<form method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12">
									<div class="image d-flex justify-content-center flex-column align-items-center">
										<img src="{{ asset('img/users/'.$user->photo) }}" class="img-setting" id="img-setting">
										<button type="button" class="btn btn-info" onclick="document.getElementById('image-user').click()">Choose image</button>
										<input type="file" id="image-user" name="photo" onchange="document.getElementById('img-setting').src = window.URL.createObjectURL(this.files[0])" class="form-hide" accept="image/x-png,image/jpeg">

									</div>
									<div class="form mt-2">
										<div class="form-group">
											<label>Fullname</label>
											<input type="text" name="name" class="form-control" value="{{ $user->name }}">
										</div>
										<div class="form-group">
											<label>Username</label>
											<input type="text" name="username" class="form-control" value="{{ $user->username }}" readonly="">
										</div>
										<div class="form-group">
											<label>Email</label>
											<input type="text" name="email" class="form-control" value="{{ $user->email }}" readonly="">
										</div>
										<div class="form-group">
											<label>No HP</label>
											<input type="text" name="phone" class="form-control" value="{{ $user->phone }}" >
										</div>
										<div class="form-group">
											<button "submit" class="btn btn-primary float-right">Ubah </button>
										</div>
									</div>
								</div>
							</div>
						</form>
						
							                
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-5">
          			<div class="card">
          				<form method="POST">
          					@csrf
	          				<div class="card-body">
          						<h4 class='header-title mt-0'>API Key</h4>
	          					<input type="text" readonly="" name="key" id="key" class="form-control" value="{{ $user->api_key}}" name="api_key">
	          				</div>
	          				<div class="mr-3 form-group overflow-hidden">
	          					<input type="submit" name="submit" class="btn btn-info float-right" value="Change API Key">
	          				</div>
          				</form>
          			</div>
          			<div class="card">
          				<form method="POST">
          					@csrf
	          				<div class="card-body">
          					<h4 class='header-title mt-0'>Ubah Password</h4>
	          					<div class="form-group">
		          					<label>Password sekarang</label>
		          					<input type="password"  name="oldpassword" id="key" class="form-control" value="" placeholder="Masukkan password sekarang">
	          					</div>
	          					<div class="form-group">
		          					<label>Password baru</label>
		          					<input type="password"  name="newpassword" id="key" class="form-control" value="" placeholder="Masukkan password sekarang">
	          					</div>
	          					<div class="form-group">
		          					<label>Ulangi password baru</label>
		          					<input type="password"  name="newpassword_confirmation" id="key" class="form-control" value="" placeholder="Masukkan password sekarang">
	          					</div>
	          				</div>
	          				<div class="mr-3 form-group overflow-hidden">
	          					<input type="submit" name="submit" class="btn btn-info float-right" value="Ubah Password">
	          				</div>
          				</form>
          			</div>
          		</div>
          	</div>
            
          </div>
        </section>

</div>
@endsection	