@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Ubah Metode Deposit</h4>
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
		                        <h4 class='header-title mt-0'><span><i class="ti-money"></i> Edit Metode Deposit</span></h4>
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
                                <label> Nama metode</label>
                                <input type="text" placeholder="BANK BCA" class="form-control" name="name" value="{{ $method->name }}">
                              </div>
                              <div class="form-group">
                                <label>Rate</label>
                                <input type="text" name="rate" placeholder="No rate = 1" class="form-control" value="{{ $method->rate }}">
                              </div>
                              <div class="form-group">
                                <label>Kode</label>
                                <select name="code" class="form-control">
                                  <option value="">Pilih salah satu</option>
                                  <option value="bca" {{ ($method->code == 'bca') ? 'selected' : '' }}>bca</option>
                                  <option value="bri" {{ ($method->code == 'bri') ? 'selected' : '' }}>bri</option>
                                  <option value="mandiri" {{ ($method->code == 'mandiri') ? 'selected' : '' }}>mandiri</option>
                                  <option value="ovo" {{ ($method->code == 'ovo') ? 'selected' : '' }}>ovo</option>
                                  <option value="gopay" {{ ($method->code == 'gopay') ? 'selected' : '' }}>gopay</option>
                                  <option value="pulsa" {{ ($method->code == 'pulsa') ? 'selected' : '' }}>pulsa</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nomor Tujuan / Rekening</label>
                                <input type="text" name="rekening" placeholder="512315213 A/N UMAM" value="{{ $method->data }}" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Atas Nama / Keterangan</label>
                                <input type="text" name="keterangan" placeholder="A/N UMAM" class="form-control" value="{{ $method->note }}">
                              </div>
                              <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control" name="type">
                                  <option value="">Pilih salah satu..</option>
                                  <option value="AUTO" {{ ($method->type == 'AUTO' ? 'selected' : '' )}}>Otomatis</option>
                                  <option value="MANUAL" {{ ($method->type == 'MANUAL' ? 'selected' : '') }}>Manual</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" name="status">
                                  <option value="">Pilih salah satu..</option>
                                  <option value="Active" {{ ($method->status == 'Active' ? 'selected':'') }}>Active</option>
                                  <option value="Not Active" {{ ($method->status == 'Not Active' ? 'selected':'') }}>Not Active</option>
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