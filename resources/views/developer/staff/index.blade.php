@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Kelola Staff</h4>
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
		                <h4 class='header-title mt-0'><span><i class=" dripicons-user-group "></i> Semua Staff</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        </div>

                    @endif
  		              <div class="card-body-header text-right">
  		                <a href="{{ url('developer/staff/add') }}" class="btn btn-primary">Tambah</a>
  		              </div>
                    <div class="clearfix mb-2"></div>
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>No Telp</th>
                            
                            <th>Email</th>
                            <th>Facebook</th>
                            <th>Photo</th>
                            <th>Action</th>
                          </tr>
                          @foreach($staff as $data)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->phone}}</td>
                            <td>{{$data->email}}</td>
                            <td><a href="{{$data->facebook_url}}">{{$data->facebook_name}}</a></td>
                            <td><img src="{{ asset('img/staff/'.$data->picture) }}" class="img-kecil"></td>
                            <td>
                              <a href="{{ url('developer/staff/edit/'.$data->id) }}" class="btn btn-info">Edit</a>
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $data->id }}" name="id">
                                <button type="button" class="btn btn-danger">Delete</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div>
                    {{$staff->links()}}
                  </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div></div>
</div>
@endsection