@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Edit Layanan</h4>
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
                            <h4 class='header-title mt-0'><span><i class="dripicons-tags"></i> Edit Layanan Sosmed</span></h4>
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
                                <label>Nama Layanan</label>
                                <input type="text" placeholder="Nama layanan.." class="form-control" name="name" value="{{ $service->name }}">
                              </div>
                              <div class="form-group">
                                <label>Tipe Layanan</label>
                                <select name="type" class="form-control">
                                  <option>Pilih tipe..</option>
                                  <option value="Basic" {{ $service->type == 'Basic' ? 'selected' : '' }}>Layanan biasa</option>
                                  <option value="Custom Comment" {{ $service->type == 'Custom Comment' ? 'selected' : '' }}>Custom Comment</option>
                                  <option value="Comment Likes" {{ $service->type == 'Comment Likes' ? 'selected' : '' }}>Comment Likes</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Kategori</label>
                                <select class="form-control" name="category">
                                  <option value="">Choose one..</option>
                                  @foreach($category as $cat)
                                    <option value="{{ $cat->id }}" {{ $service->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Catatan</label>
                                <textarea class="form-control" name="note">{{ $service->note }}</textarea>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col">
                                    <label>Min</label>
                                    <input type="number" name="min" class="form-control" value="{{ $service->min }}">
                                  </div>
                                  <div class="col">
                                    <label>Max</label>
                                    <input type="number" name="max" class="form-control" value="{{ $service->max }}">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col">
                                    <label>Harga asli</label>
                                    <input type="number" name="price" class="form-control" value="{{ $service->price }}">
                                  </div>
                                  <div class="col">
                                    <label>Keuntungan</label>
                                    <input type="number" name="keuntungan" class="form-control" value="{{ $service->keuntungan }}">
                                  </div>
                                  <div class="col">
                                    <label>Harga khusus API</label>
                                    <input type="number" name="price_oper" class="form-control" value="{{ $service->price_oper }}">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="row">
                                  <div class="col">
                                    <label>Provider id</label>
                                    <input type="number" name="pid" class="form-control" value="{{ $service->pid }}">
                                  </div>
                                  <div class="col">
                                    <label>Provider</label>
                                    <select class="form-control" name="provider">
                                      @foreach($provider as $prov)
                                        <option value="{{$prov->id}}" {{ $service->provider_id == $prov->id ? 'selected' : '' }}>{{$prov->name}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                  <option>Select one</option>
                                  <option value="Active" {{ $service->status == 'Active' ? 'selected' : '' }}>Active</option>
                                  <option value="Not Active" {{ $service->status == 'Not Active' ? 'selected' : '' }}>Not Active</option>
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
        </div>
      </div>
</div>
@endsection