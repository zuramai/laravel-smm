@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Kelola Provider</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

          <div class="section-body">
          
          	<div class="row">
          		<div class="col-md-12">
          			<div class="card">
		              <div class="">
                  </div>
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span>Daftar Provider</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    @endif
  		              <div class="card-body-header text-right">
  		                <a href="{{ url('developer/providers/add') }}" class="btn btn-primary">Tambah</a>
  		              </div>
                    <div class="mb-3"></div>
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Nama Provider</th>
                            <th>Order Endpoint</th>
                            <th>Status Endpoint</th>
                            <th>Action</th>
                          </tr>
                          @foreach($prov as $data)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$data->name}}</td>
                            @if($data->order_type == 'API')
                                <td>{{$data->api->order_end_point}}</td>
                                <td>{{$data->api->status_end_point}}</td>
                            @else
                                <td>MANUAL</td>
                                <td>MANUAL</td>
                            @endif
                            <td>
                              <a href="{{ url('developer/providers/edit/'.$data->api->id) }}" class="btn btn-info">Edit</a>
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $data->api->id }}" name="id">
                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Jika menghapus provider, akan menghapus semua layanan dan kategori dengan provider tersebut">Delete</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div>
                    {{$prov->links()}}
                  </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div></div>
</div>
@endsection