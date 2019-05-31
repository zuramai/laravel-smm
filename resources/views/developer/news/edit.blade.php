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
                        <form method="POST" action="">
                            @csrf
                          <div class="card-body">
		                        <h4 class='header-title mt-0'><span><i class=" ti-files "></i> Edit Berita</span></h4>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                              <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control" name="type">
                                  <option>Select one..</option>
                                  <option value="Service" {{ $news->type == 'Service' ? 'selected' : '' }}>Service</option>
                                  <option value="Info" {{ $news->type == 'Info' ? 'selected' : '' }}>Info</option>
                                  <option value="Update" {{ $news->type == 'Update' ? 'selected' : '' }}>Update</option>
                                  <option value="Maintenance" {{ $news->type == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="title" value="{{ $news->title }}">
                              </div>
                              <div class="form-group">
                                <label>Konten</label>
                                <textarea class="form-control" name="content">{{ $news->content }}</textarea>
                              </div>
                              
                          </div>
                          <div class="mr-3 form-group text-right">
                            <button type="submit" class="btn btn-primary">Edit</button>
                          </div>    
                        </form>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div></div>
</div>
@endsection