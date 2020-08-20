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
		              <div class="">
                  </div>
                  <div class="card-body">
		                <h4 class='header-title mt-0'><span><i class=" dripicons-tags "></i> Kelola Layanan Sosial Media</span></h4>
                    @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    	@endif
                    <div class="float-left">
                      <form method="GET">
                        <div class="input-group">
                          <input type="text" class="form-control" placeholder="Cari nama layanan" name="search">
                          <div class="input-group-append">                                            
                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="float-right">
                      <a href="{{ url('developer/services/add') }}" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="clearfix mb-3"></div>
                    <div class="table-responsive">
  		                <table class="table table-striped table-md">
                          <tr>                          
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Min</th>
                            <th>Max</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Provider</th>
                            <th>Action</th>
                          </tr>
                          @foreach($service as $data)
                          <tr>
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->category->name }}</td>
                            <td>{{ $data->min }}</td>
                            <td>{{ $data->max }}</td>
                            <td>{{ config('web_config')['CURRENCY_CODE'] }} {{ $data->price + $data->keuntungan }}</td>
                            <td><span class="badge badge-{{ $data->status=='Active' ? 'success' : 'danger' }}">{{$data->status}}</span></td>
                            <td>{{ $data->provider->name }}</td>
                            <td style="display: inline-block;">
                              <a href="{{ url('developer/services/edit/'.$data->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                              <form method="POST" class="form-delete">
                                  @method('delete')
                                  @csrf
                                  <input type="hidden" value="{{ $data->id }}" name="id">
                                  <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Saran: Jangan hapus layanan, karena akan menghapus seluruh data order dengan layanan ini. Lebih baik nonaktifkan layanan">
                                    <i class="fa fa-trash"></i>
                                  </button>
                                </form>

                            </td>
                          </tr>
                          @endforeach
                      </table>
                    </div>
                    {{$service->links()}}
		              </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection