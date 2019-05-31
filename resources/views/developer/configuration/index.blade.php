@extends('layouts.horizontal-developer')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="page-title-box">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="page-title m-0"> Konfigurasi Website</h4>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <h4 class='header-title mt-0'><span><i class="ti-settings mr-1"></i> Kelola Website</span></h4>
                        @if(session('success'))

                          <div class="alert alert-success" role="alert">
                              <i class="fa fa-check-circle"></i> {!! session('success') !!}
                          </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Nama Website: </label>
                                <div class="col-md-9">
                                    <input type="text" name="web_name" placeholder="Judul website" class="form-control " value="{{ config('web_config')['APP_NAME'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Judul Website: </label>
                                <div class="col-md-9">
                                    <input type="text" name="web_title" placeholder="Judul website" class="form-control " value="{{ config('web_config')['WEB_TITLE'] }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Logo (light text): </label>
                                <div class="col-md-2">
                                    <img src="{{ config('web_config')['WEB_LOGO_URL'] }}" class="object-fit-cover w-100">
                                </div>
                                <div class="input-group mb-3 col-md-7">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="web_logo" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Logo (dark text): </label>
                                <div class="col-md-2">
                                    <img src="{{ config('web_config')['WEB_LOGO_URL_DARK'] }}" class="object-fit-cover w-100">
                                </div>
                                <div class="input-group mb-3 col-md-7">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="web_logo_dark" id="inputGroupFile02">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Favicon (dark text): </label>
                                <div class="col-md-2">
                                    <img src="{{ config('web_config')['WEB_FAVICON_URL'] }}" class="object-fit-cover" style="width: 30px;">
                                </div>
                                <div class="input-group mb-3 col-md-7">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="inputGroupFile02" name="favicon">
                                    <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Deskripsi Website : </label>
                                <div class="col-md-9">
                                    <textarea class="form-control " name="web_description">{{ config('web_config')['WEB_DESCRIPTION'] }}</textarea>
                                    <div class="form-text text-muted">Deskripsi akan tampil di google search</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Deskripsi Halaman Login: </label>
                                <div class="col-md-9">
                                    <textarea class="summernote" name="login_desc">
                                        @if(config('web_config')['WEB_AUTH_DESCRIPTION'] == '')
                                            <h5 class="font-14 text-muted mb-4">{{config('web_config')["APP_NAME"]}}, Website Penyedia Jasa Sosial Media & Pulsa PPOB Terbaik</h5>
                                            <p class="text-muted mb-4">Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.
                                            Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll. Dan kamipun juga menyediakan Panel Pulsa & PPOB seperti Pulsa All Operator, Paket Data, Saldo Gojek/Grab, All Voucher Game Online, Dll.</p>

                                            <h5 class="font-14 text-muted mb-4">Kelebihan {{config('web_config')['APP_NAME']}} :</h5>
                                            <div>
                                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>Harga Instagram Followers mulai dari Rp 100 per 1000</p>
                                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>Harga Instagram Likes mulai dari Rp 0.</p>
                                                <p><i class="mdi mdi-arrow-right text-primary mr-2"></i>Harga Youtube Subscriber mulai dari Rp 10.000 per 1k subscriber</p>
                                            </div>  
                                        @else
                                            {{config('web_config')['WEB_AUTH_DESCRIPTION']}}
                                        @endif
                                    </textarea>
                                </div>
                            </div>
                            <div class="mt-5"></div>
                            <hr>
                            <div class="mb-5"></div>
                            <h4 class='header-title mt-0'><span><i class="ti-settings mr-1"></i> Staff menu</span></h4>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Harga Tambah Member: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Harga Tambah Member" class="form-control" value="{{ config('web_config')['ADD_MEMBER_PRICE'] }}" name="add_member_price">
                                </div>
                                <label class="col-form-label col-md-2">Bonus Saldo: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Bonus Saldo Member" class="form-control" value="{{ config('web_config')['MEMBER_BALANCE'] }}" name="member_balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Harga Tambah Agen: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Harga Tambah Agen" class="form-control" value="{{ config('web_config')['ADD_AGEN_PRICE'] }}" name="add_agen_price">
                                </div>
                                <label class="col-form-label col-md-2">Bonus Saldo: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Bonus Saldo Agen" class="form-control" value="{{ config('web_config')['AGEN_BALANCE'] }}" name="agen_balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Harga Tambah Reseller: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Judul website" class="form-control" value="{{ config('web_config')['ADD_RESELLER_PRICE'] }}" name="add_reseller_price">
                                </div>
                                <label class="col-form-label col-md-2">Bonus Saldo: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Bonus Saldo Reseller" class="form-control" value="{{ config('web_config')['RESELLER_BALANCE'] }}" name="reseller_balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Harga Tambah Admin: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Harga Tambah Admin: " class="form-control" value="{{ config('web_config')['ADD_ADMIN_PRICE'] }}" name="add_admin_price">
                                </div>
                                <label class="col-form-label col-md-2">Bonus Saldo: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Bonus Saldo Admin" class="form-control" value="{{ config('web_config')['ADMIN_BALANCE'] }}" name="admin_balance">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Minimal Voucher: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Minimal Voucher " class="form-control" value="{{ config('web_config')['MIN_VOUCHER'] }}" name="min_voucher">
                                </div>
                                <label class="col-form-label col-md-2">Maksimal Voucher: </label>
                                <div class="col-md-3">
                                    <input type="text"  placeholder="Maksimal Voucher" class="form-control" value="{{ config('web_config')['MAX_VOUCHER'] }}" name="max_voucher">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-md-3">Minimal Deposit: </label>
                                <div class="col-md-9">
                                    <input type="text"  placeholder="Minimal deposit" class="form-control " value="{{ config('web_config')['MIN_VOUCHER'] }}" name="min_deposit">
                                </div>
                            </div>
                            <div class="float-right">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('links')
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
@endpush
@push('scripts')

    <!--Summernote js-->
    <script src="../plugins/summernote/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.summernote').summernote({
                height: 100,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true                 // set focus to editable area after initializing summernote
            });
        });
    </script>
@endpush

@endsection