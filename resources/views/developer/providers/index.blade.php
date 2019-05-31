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
		                <h4 class='header-title mt-0'><span>Provider</span></h4>
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
                            <th>Name</th>
                            <th>API Key</th>
                            <th>API Link</th>
                            <th>Type</th>
                            <th>Action</th>
                          </tr>
                          @foreach($prov as $data)
                          <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->api_key}}</td>
                            <td>{{$data->link}}</td>
                            <td>{{$data->type}}</td>
                            <td>
                              <a href="{{ url('developer/providers/edit/'.$data->id) }}" class="btn btn-info">Edit</a>
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $data->id }}" name="id">
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