@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Ubah Kategori</h4>
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
                        <form method="POST" action="">
                          @method('PUT')
                            @csrf
                          <div class="card-body">
		                        <h4 class='header-title mt-0'><span><i class="fas fa-edit"></i> Ubah Kategori Layanan</span></h4>
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
                                <label>Nama kategori</label>
                                <input type="text" placeholder="Nama kategori.." class="form-control" name="name" value="{{ $scat->name }}">
                              </div>
                              <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control" name="type">
                                  <option value="">Choose one..</option>
                                  <option value="SOSMED" {{ ($scat->type == 'SOSMED') ? 'selected' : '' }}>Sosial Media</option>
                                  <option value="PULSA" {{ ($scat->type == 'PULSA') ? 'selected' : '' }}>Pulsa</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                  <option value="">Choose one..</option>
                                  <option value="Active" {{ ($scat->status == 'Active') ? 'selected' : '' }}>Active</option>
                                  <option value="Not Active" {{ ($scat->status == 'Not Active') ? 'selected' : '' }}>Not Active</option>
                                </select>
                              </div>
                              
                          </div>
                          <div class="mr-3 form-group text-right">
                            <button type="submit" class="btn btn-primary">Ubah</button>
                          </div>    
                        </form>
		            </div>
          		</div>
          	</div>
            
          </div>
        </div>
      </div>
</div>
@endsection