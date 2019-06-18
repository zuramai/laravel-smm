@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0"> Tambah Metode Deposit</h4>
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
		                        <h4 class='header-title mt-0'><span><i class="ti-money"></i> Metode Deposit Baru</span></h4>
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
                                <input type="text" placeholder="MANDIRI" class="form-control" name="name">
                              </div>
                              <div class="form-group">
                                <label>Kode</label>
                                <select name="code" class="form-control">
                                  <option value="">Pilih salah satu</option>
                                  <option value="bca">bca</option>
                                  <option value="bri">bri</option>
                                  <option value="mandiri">mandiri</option>
                                  <option value="ovo">ovo</option>
                                  <option value="gopay">gopay</option>
                                  <option value="pulsa">pulsa</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control" name="type">
                                  <option value="">Pilih salah satu..</option>
                                  <option value="AUTO">Otomatis</option>
                                  <option value="MANUAL">Manual</option>
                                </select>
                              </div>
                              <div class="form-group">
                                <label>Nomor Tujuan / Rekening</label>
                                <input type="text" name="rekening" placeholder="1290011202799" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Atas Nama / Keterangan</label>
                                <input type="text" name="keterangan" placeholder="A/N UMAM" class="form-control">
                              </div>
                              <div class="form-group">
                                <label>Rate</label>
                                <input type="text" name="rate" placeholder="No rate = 1" class="form-control">
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