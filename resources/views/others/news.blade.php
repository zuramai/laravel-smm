@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Berita</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>

       
      	<div class="row">
      		<div class="col-md-12">
      			<div class="card">
          
                    <div class="card-body">
	                   <h4 class='header-title mt-0'><span>Berita Terbaru</span></h4>
                        @if(session('success'))

                            <div class="alert alert-success" role="alert">
                                <i class="fa fa-check-circle"></i> {{ session('success') }}
                            </div>

                        @endif
        		              
                        <div class="table-responsive">
                          <table class="table table-striped table-md">
                              <tr>
                                <th>Tanggal</th>
                                <th>Tipe</th>
                                <th>Judul</th>
                                <th>Isi</th>
                              </tr>
                              @foreach($news as $data)
                              <tr>
                                <td>{{ date('d F Y H:i', strtotime($data->created_at)) }}</td>
                                 <td>
                                    <span class="badge badge-{{ ($data->type == 'Maintenance' ? 'danger' : ($data->type == 'Info' ? 'info' : 'primary')) }}">
                                      
                                    {{ $data->type }}
                                    </span>
                                  </td>
                                <td>{{ $data->title }}</td>
                                <td>{!! nl2br(htmlentities($data->content)) !!}</td>
                              </tr>
                              @endforeach
                          </table>
                        </div>
                <div class="mt-3">{{ $news->links() }}</div>
              </div>
	            </div>
      		</div>
      	</div>
            
    </div>
</div>
</div>
@endsection