@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"><i class="dripicons-user"></i> Tambah Pengguna</h4>
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
		                        <h4 class='header-title mt-0'><span>Tambah Pengguna</span></h4>
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
                                <input type="text"  class="form-control" name="name">
                              </div>
                              <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                              </div>
                              <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name='password'>
                              </div>
                              <div class="form-group">
                                <label>Balance</label>
                                <input type="number" class="form-control" value="0" name='balance'>
                              </div>
                              <div class="form-group">
                                <label for="">Level</label>
                                <select name="level" id="" class="form-control">
                                    <option value="Member">Member</option>
                                    <option value="Agen">Agen</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Developer">Developer</option>
                                </select>
                              </div>
                              
                              
                              
                          </div>
                          <div class="mr-3 form-group text-right">
                            <button type="submit" class="btn btn-primary">Tambah</button>
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