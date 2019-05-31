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
                        <form method="POST" action="">
                            @csrf
                          <div class="card-body">
		                    <h4 class='header-title mt-0'><span>Ubah Layanan Pulsa</span></h4>
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
                                <label>Kategori</label>
                                <select name="category" class="form-control">
                                  <option>Pilih kategori..</option>
                                  @foreach($category as $cat)
                                  <option value="{{ $cat->id }}" {{ ($cat->id == $service->category_id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Operator</label>
                                <select class="form-control" name="oprator">
                                  <option value="">Choose one..</option>
                                  @foreach($operator as $oprator)
                                    <option value="{{ $oprator->id }}" {{ ($oprator->id == $service->oprator_id) ? 'selected' : '' }}>{{ $oprator->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama Layanan</label>
                                <input type="text" placeholder="Nama layanan.." class="form-control" name="name" value="{{ $service->name }}">
                              </div>
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="price" class="form-control" placeholder="Harga layanan.." value="{{ $service->price }}">
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label>Keuntungan</label>
                                    <input type="number" name="keuntungan" class="form-control" placeholder="Keuntungan " value="{{ $service->keuntungan }}">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <label>Code / Provider ID</label>
                                <input type="text" name="code" class="form-control" placeholder="Masukkan kode/id layanan dari provider" class="form-control" value="{{ $service->code }}">
                              </div>
                              <div class="form-group">
                                <label>Provider</label>
                                <select class="form-control" name="provider">
                                  <option>Pilih provider..</option>
                                  @foreach($provider as $prov) 
                                  <option value="{{$prov->id}}" {{ ($prov->id == $service->provider_id) ? 'selected' : '' }}>{{ $prov->name }}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                  <option>Pilih salah satu..</option>
                                  <option value="Active" {{ $service->status =='Active' ? 'selected' : '' }}>Active</option>
                                  <option value="Not Active" {{ $service->status =='Not Active' ? 'selected' : '' }}>Not Active</option>
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
        </div>
    </div>
</div>
@endsection