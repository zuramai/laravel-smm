@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Edit Operator</h4>
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
		                        <h4 class='header-title mt-0'><span><i class="ti-marker-alt"></i> Edit Operator Pulsa</span></h4>
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
                                <label>Pilih Kategori</label>
                                <select class="form-control" name="category">
                                  <option>Pilih salah satu..</option>
                                  @foreach($cat as $data_cat)
                                  <option value="{{$data_cat->id}}" {{ ($oprator->category_id == $data_cat->id) ?"selected":"" }}>{{$data_cat->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nama Operator</label>
                                <input type="text" name="name" class="form-control" value="{{ $oprator->name }}" placeholder="Contoh: Telkomsel, Voucher Garena">
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