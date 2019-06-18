@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> CUSTOM PRICE</h4>
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
		                <h4 class='header-title mt-0'><span><i class=" dripicons-view-list-large "></i> Daftar harga spesial</span></h4>
			              @if ($errors->any())
	                            <div class="alert alert-danger">
	                                <ul>
	                                    @foreach ($errors->all() as $error)
	                                        <li>{{ $error }}</li>
	                                    @endforeach
	                                </ul>
	                            </div>
	                        @endif
	                        @if(session('success'))

		                        <div class="alert alert-success" role="alert">
		                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
		                        </div>

	                    	@endif
	                        @if(session('danger'))

		                        <div class="alert alert-danger" role="alert">
		                            <i class="fa fa-check-circle"></i> {!! session('danger') !!}
		                        </div>

	                    	@endif
		              	
						<div class="table-responsive">
							<div class="float-right mb-2">
								<button type="button" data-toggle="modal" data-target="#modalAdd" class="btn btn-primary">Tambah</button>
								<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="exampleModalLabel">Tambah data</h5>
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          <span aria-hidden="true">&times;</span>
								        </button>
								      </div>
							        	<form method="POST">
							        		@csrf
									      	<div class="modal-body">
									        	<div class="form-group">
									        		<label>Email/username pengguna</label>
									        		<input type="text" name="email" class="form-control">
									        	</div>
									        	<div class="form-group">
									        		<label>Service ID (service id <a href="{{ url('/price/sosmed') }}">lihat disini</a>)</label>
									        		<input type="text" name="serviceid" class="form-control">
									        	</div>
									        	<div class="form-group">
									        		<label>Jumlah potongan</label>
									        		<input type="text" name="potongan" class="form-control">
									        	</div>
									      	</div>
									      	<div class="modal-footer">
									        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									        	<button type="submit" class="btn btn-primary">Submit</button>
									      </div>
									  </form>
								    </div>
								  </div>
								</div>
							</div>
							<table class="table table-striped table-md">
								<tr>
									<th>#</th>
									<th>User</th>
									<th>Service</th>
									<th>Harga asli</th>
									<th>Potongan</th>
									<th>Action</th>
								</tr>
									@foreach($custom_prices as $custom_price)
									<tr>
										<td>#{{ $loop->iteration }}</td>
										<td>{{ $custom_price->user->email }} ({{ $custom_price->user->name }})</td>
										<td>{{ $custom_price->service->name }}</td>
										<td>Rp {{ number_format($custom_price->service->price + $custom_price->service->keuntungan) }}</td>
										<td>Rp {{ number_format($custom_price->potongan) }}</td>
										<td>
											<form method="POST" class="form-delete">
	                                            @method('delete')
	                                            @csrf
	                                            <input type="hidden" value="{{ $custom_price->id }}" name="id">
	                                            <button type="button" class="btn btn-danger">
	                                                <i class="fa fa-trash"></i>
	                                            </button>
	                                        </form>
										</td>
									</tr>
									@endforeach
									@forelse($custom_prices as $custom_price)
									@empty
									<tr>
										<td colspan="6" class="text-center">No data</td>
									</tr>
									@endforelse
							</table>
						</div>
						<div class="float-right mt-2">
							{{ $custom_prices->links() }}
						</div>
							                
		              </div>
		            
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
    </div>
</div>
@endsection