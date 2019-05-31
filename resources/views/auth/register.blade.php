@extends('layouts.auth')

@section('content')
@section('app_title','Register - '.config('web_config')['WEB_TITLE'])
<div class="container-fluid">


<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div>
                <div >
                    <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                </div>
                {!! config('web_config')['WEB_AUTH_DESCRIPTION'] !!}
        </div>
        <div class="col-lg-5 offset-lg-1">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="p-2">
                        <h4 class="text-muted float-right font-18 mt-4">Register</h4>
                        <div>
                            <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                        </div>
                    </div>

                    <div class="p-2">
                        <form class="form-horizontal m-t-20"  method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                  <label for="first_name">Nama depan</label>
                                  <input id="first_name" type="text" class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" autofocus placeholder="Nama depan">
                                  @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                  <label for="last_name">Nama Belakang</label>
                                  <input id="last_name" type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" placeholder="Nama belakang">
                                </div>
                              </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" placeholder="Email">
                                 @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">Username</label>
                                <input id="username" type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" placeholder="Username">
                                 @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">No HP</label>
                                <input id="phone" type="text" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" placeholder="Nomor handphone">
                                 @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                  <label for="password" class="d-block">Password</label>
                                  <input id="password" type="password" class="form-control pwstrength {{ $errors->has('password') ? ' is-invalid' : '' }}" data-indicator="pwindicator" name="password">
                                  <div id="pwindicator" class="pwindicator">
                                    <div class="bar"></div>
                                    <div class="label"></div>
                                  </div>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group col-6">
                                  <label for="password2" class="d-block">Konfirmasi password</label>
                                  <input id="password2" type="password" class="form-control" name="password_confirmation">
                                </div>
                              </div>


                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Register</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-12 m-t-20 text-center">
                                    <a href="{{route('login')}}" class="text-muted">Sudah punya akun?</a>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
</div>
</div>
@endsection
