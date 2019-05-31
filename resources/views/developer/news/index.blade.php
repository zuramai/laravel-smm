@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Kelola Berita</h4>
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
		                <h4 class='header-title mt-0'><span><i class=" ti-files "></i> Kelola Berita</span></h4>
                     @if(session('success'))

                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check-circle"></i> {{ session('success') }}
                        </div>

                    @endif
  		              <div class="card-body-header text-right">
  		                <a href="{{ url('developer/news/add') }}" class="btn btn-primary">Tambah</a>
  		              </div>
                    <div class="mb-3"></div>
                    <div class="table-responsive">
                      <table class="table table-striped table-md">
                          <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Judul</th>
                            <th>Content</th>
                            <th>Action</th>
                          </tr>
                          @foreach($news as $data)
                            <tr>
                              <td>{{ $data->id }}</td>
                              <td>{{ date('d F Y' , strtotime($data->created_at)) }}</td>
                              <td>
                                <span class="badge badge-{{ ($data->type == 'Maintenance' ? 'danger' : ($data->type == 'Info' ? 'info' : 'primary')) }}">
                                  
                                {{ $data->type }}
                                </span>
                              </td>
                              <td>{{ $data->title }}</td>
                              <td><?php  echo nl2br($data->content) ?></td>
                              <td class="inline-button">
                                <a href="{{url('developer/news/edit/'. $data->id) }}" class="btn btn-primary">
                                  <i class="fa fa-edit"></i>
                                </a>
                                <form method="POST">
                                  @method('delete')
                                  @csrf
                                  <input type="hidden" value="{{ $data->id }}" name="id">
                                  <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                      </table>
                    </div>
                    {{$news->links()}}
                  </div>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection