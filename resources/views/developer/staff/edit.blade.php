@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Edit Staff</h4>
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
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                          <div class="card-body">
		                        <h4 class='header-title mt-0'><span><i class=" dripicons-user-group "></i> Ubah Staff</span></h4>
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
                                <label>Nama Lengkap</label>
                                <input type="text"  class="form-control" name="name" value="{{ $staff->name }}">
                              </div>
                              <div class="form-group">
                                <label>Nomor telepon</label>
                                <input type="text" class="form-control" name="phone" value="{{ $staff->phone }}">
                              </div>
                              <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email" value="{{ $staff->email }}">
                              </div>
                              <div class="form-group">
                                <label>Level</label>
                                <select class="form-control" name="level">
                                  <option value="">Pilih salah satu</option>
                                  <option value="Member" {{ ($staff->level == 'Member') ? 'selected' : '' }}>Member</option>
                                    <option value="Agen" {{ ($staff->level == 'Agen') ? 'selected' : '' }}>Agen</option>
                                    <option value="Reseller" {{ ($staff->level == 'Reseller') ? 'selected' : '' }}>Reseller</option>
                                    <option value="Admin" {{ ($staff->level == 'Admin') ? 'selected' : '' }}>Admin</option>
                                    <option value="Developer" {{ ($staff->level == 'Developer') ? 'selected' : '' }}>Developer</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama Facebook <span class="text-muted">*Opsional</span></label>
                                <input type="text" class="form-control" name="fb_name" value="{{ $staff->facebook_name }}">
                              </div>
                              <div class="form-group">
                                <label>Link Facebook <span class="text-muted">*Opsional(wajib jika isi nama facebook)</span></label>
                                <input type="text" class="form-control" name="fb_link" value="{{ $staff->facebook_url }}">
                              </div>
                              <div class="form-group">
                                <label>Foto <span class="text-muted">*Wajib</span></label>
                                <input type="file" name="photo" class="form-control-file" value="{{ $staff->photo }}">
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
        </div></div>
</div>
@endsection