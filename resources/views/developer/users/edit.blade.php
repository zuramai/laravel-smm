@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Edit Pengguna</h4>
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
                            @csrf
                          <div class="card-body">
		                        <h4 class='header-title mt-0'><span> <i class="dripicons-user"></i> Edit Pengguna</span></h4>
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
                                <label>Nama</label>
                                <input type="text"  class="form-control" name="name" value="{{$user->name}}">
                              </div>
                              <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{$user->email}}">
                              </div>
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name='password' value="{{$user->password}}">
                              </div>
                              <div class="form-group">
                                <label>Balance</label>
                                <input type="number" class="form-control" value="0" name='balance' value="{{$user->balance}}">
                              </div>
                              <div class="form-group">
                                <label for="">Level</label>
                                <select name="level" id="" class="form-control">
                                    <option value="Member" {{ ($user->level == 'Member' ? 'selected' : '' )}}>Member</option>
                                    <option value="Agen" {{ ($user->level == 'Agen' ? 'selected' : '' )}}>Agen</option>
                                    <option value="Reseller" {{ ($user->level == 'Reseller' ? 'selected' : '' )}}>Reseller</option>
                                    <option value="Admin" {{ ($user->level == 'Admin' ? 'selected' : '' )}}>Admin</option>
                                    <option value="Developer" {{ ($user->level == 'Developer' ? 'selected' : '' )}}>Developer</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value="Member">Pilih salah satu</option>
                                    <option value="Active" {{ ($user->status == 'Active' ? 'selected' : '' )}}>Active</option>
                                    <option value="Not Active" {{ ($user->status == 'Not Active' ? 'selected' : '' )}}>Not Active</option>
                                </select>
                              </div>
                              
                              
                              
                          </div>
                          <div class="form-group mr-3 text-right">
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