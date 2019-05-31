@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Kategori</h4>
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
                    <h4 class='header-title mt-0'><span><i class=" ti-bookmark-alt "></i>  Kelola Kategori Sosial Media</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {!! session('success') !!}
                        </div>

                    @endif
                    <div class="float-left">
                      <form method="GET">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Cari nama kategori" name="search">
                          <div class="input-group-append">                                            
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="float-right">
                      <a href="{{ route('dev_services_add_post') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="clearfix mb-3"></div>
                    
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                          @foreach($service_cat as $data)
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->type}}</td>
                            <td><span class="badge badge-{{ $data->status=='Active' ? 'success' : 'danger' }}">{{$data->status}}</span></td>
                            <td>
                              <a href="{{ url('developer/services_cat/edit/'.$data->id) }}" class="btn btn-info">Edit</a>
                              <form method="POST" class="form-delete">
                                @method('delete')
                                @csrf
                                <input type="hidden" value="{{ $data->id }}" name="id">
                                <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Jika menghapus kategori, akan menghapus semua layanan dengan kategori yang dihapus">Delete</button>
                              </form>
                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div>
                    <div class="mt-2 float-right">{{$service_cat->links()}}</div>
                  </div>
                </div>
              </div>
              
            </div>
            
          </div>
        </div>
      </div>
</div>
@endsection