@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Tiket</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-12">
          			<div class="card">
		             
		              <div class="card-body">
		                <h4 class='header-title mt-0'><span>Tiket Baru</span></h4>
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
						<div class="form">
							<form method="POST" action="">
								@csrf
							  <div class="form-group row">
							    <label for="staticEmail" class="col-sm-2 col-form-label">Judul</label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" placeholder="Judul tiket" name="title">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="inputPassword" class="col-sm-2 col-form-label">Konten</label>
							    <div class="col-sm-10">
							      <textarea class="form-control" placeholder="Jelaskan masalahmu disini.." name="content"></textarea>
							    </div>
							  </div>
							  <div class="float-right">
							  	<button type="submit" class="btn btn-primary">Submit</button>
							  </div>
							</form>
						</div>		
	                     
		              </div>
		            
		            </div>
          		</div>
          		<div class="col-md-4">
          			
          		</div>
          	</div>
            
          </div>
        </div>
    </div>




</div>
@endsection	