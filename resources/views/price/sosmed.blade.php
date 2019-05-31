@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Daftar Harga</h4>
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
		                <h4 class='header-title mt-0'><span>Daftar Layanan Sosial Media</span></h4>
		              	@if(session('success'))
	                        <div class="alert alert-primary" role="alert">
	                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
	                        </div>
		              	@elseif(session('danger'))
	                        <div class="alert alert-danger" role="alert">
	                            <i class="fa fa-exclamation-circle"></i> {{ session('danger') }}
	                        </div>
	                    @endif
	                    @if ($errors->has('quantity'))
		                    	<div class="alert alert-danger" role="alert">
		                            <i class="fa fa-exclamation-circle"></i> {{ $errors->first('quantity') }}
		                        </div>
						@endif

						<div class="float-right">
	                        <form method="GET">
	                          <div class="input-group">
	                            <input type="text" name="search" class="form-control" placeholder="Search">
	                            <div class="input-group-append">                                            
	                              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
	                            </div>
	                          </div>
	                        </form>
	                      </div>
	                      <div class="clearfix mb-3"></div>
						<div class="table-responsive">
							<table class="table table-striped table-lg">
								<tr>
									<th>ID</th>
									<th>Category</th>
									<th>Name</th>
									<th>Min/Max</th>
									<th>Price</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
									@foreach($service as $data_service)
									<tr>
										<td id="service_id">{{ $data_service->id }}</td>
										<td>{{ $data_service->category->name }}</td>
										<td>{{ $data_service->name }}</td>
										<td>{{ $data_service->min }}/{{ $data_service->max }}</td>
										<td>Rp {{ number_format($data_service->price) }}</td>
										<td><span class="badge badge-{{ ($data_service->status=='Active') ? 'success':'danger' }}">{{ $data_service->status }}</span></td>
										<td>
											<button type='button' href="#" class="btn btn-secondary detailSosmed">Detail</button>
										</td>
									</tr>
									@endforeach
							</table>
						</div>
						<div class="float-right">
							{{ $service->links() }}
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
<!-- Modal -->
<div class="modal fade" id="priceSosmed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" id="detailModalTitle">Detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detailModalBody">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection