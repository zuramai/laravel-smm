@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Layanan</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-12">
          			<div class="card">
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Kelola Layanan Pulsa</span></h4>
		              	@if(session('success'))

                        <div class="alert alert-primary" role="alert">
                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        </div>

                    	@endif
		              	
		                <div class="float-left">
                      <a href="{{ url('developer/services_pulsa/add') }}" class="btn btn-primary">Tambah Layanan</a>
                    </div>
                      <div class="float-right">
                        <form method="GET">
                          <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search" name="search">
                            <div class="input-group-append">
                              <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                            </div>
                          </div>
                        </form>
                      </div>

                    <div class="clearfix mb-3"></div>

                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>Nama</th>
                          <th>Kategori</th>
                          <th>Operator</th>
                          <th>Harga</th>
                          <th>Keuntungan</th>
                          <th>Status</th>
                          <th>Provider</th>
                          <th>Action</th>
                        </tr>
                        @foreach($services as $service)
                        <tr>
                          <td>
                            {{ $service->id }}
                          </td>
                          <td>
                            {{$service->code}}
                          </td>
                          <td>
                            {{$service->name}}
                          </td>
                          <td>
                            {{$service->category->name}}
                          </td>
                          <td>
                            {{$service->oprator->name}}
                          </td>
                          <td>
                            {{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($service->price)}}
                          </td>
                          <td>
                            {{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($service->keuntungan)}}
                          </td>
                          <td>
                            <span class="badge badge-{{ ($service->status == 'Active' ? 'success' : 'danger') }}">{{$service->status}}</span>
                          </td>
                          <td>
                            {{$service->provider->name}}
                          </td>
                          <td>
                            <a href="{{ url('developer/services_pulsa/edit/'.$service->id) }}" class="btn btn-primary">
                              <i class="fa fa-edit"></i>
                            </a>  
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $service->id }}" name="id">
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                              </form>
                          </td>
                        </tr>
                        @endforeach
                      </table>
                    </div> 
                    <div class="mt-2"></div>
                    {{ $services->links() }}   
                  </div>
                </div>
              </div>
            </div>
      		</div>
  	</div>
            
</div>

</div>
@endsection