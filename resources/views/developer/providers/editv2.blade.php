@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Edit Provider</h4>
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
                            <h4 class='header-title mt-0'><span><i class="fas fa-edit"></i> Edit provider</span></h4>
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
                                <label>Nama provider</label>
                                <input type="text"  class="form-control" name="name" value="{{ $prov->name }}">
                              </div>
                              <div class="form-group">
                                <label>API Key</label>
                                <input type="text" class="form-control" name="key" value="{{ $prov->api_key }}">
                              </div>
                              <div class="form-group">
                                <label>API Link</label>
                                <input type="text" class="form-control" name="link" value="{{ $prov->link }}">
                              </div>
                              <div class="form-group">
                                <label>Tambahan</label>
                                <input type="text" class="form-control" name="additional" placeholder="Masukkan data tambahan disini" value="{{ $prov->additional }}">
                              </div>
                              <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control" name="type">
                                  <option value="">Choose one..</option>
                                  <option value="SOSMED" {{ ($prov->type == "SOSMED") ?"selected":"" }}>Sosial Media</option>
                                  <option value="PULSA" {{ ($prov->type == "PULSA") ?"selected":"" }}>Pulsa</option>
                                </select>
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