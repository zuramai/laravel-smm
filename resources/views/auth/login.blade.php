@extends('layouts.auth')

@section('content')
@section('app_title','Login - '.config('web_config')['WEB_TITLE'])
<div class="container-fluid">
  <div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div>
                <div>
                    <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                </div>
                {!! config('web_config')['WEB_AUTH_DESCRIPTION'] !!}
            </div>
        </div>
        <div class="col-lg-5 offset-lg-1">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="p-2">
                        <h4 class="text-muted float-right font-18 mt-4">Sign In</h4>
                        <div>
                            <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                        </div>
                    </div>

                    <div class="p-2">
                          @if(session('success'))
                              <div class="alert alert-primary" role="alert">
                                  <i class="fa fa-check-circle"></i> {!! session('success') !!}
                              </div>
                          @elseif(session('danger'))
                            <div class="alert alert-danger" role="alert">
                                <i class="fa fa-exclamation-circle"></i> {!! session('danger') !!}
                            </div>
                          @endif
                        <form class="form-horizontal m-t-20 needs-validation" method="POST" action="#"  novalidate="">
                          @csrf
                            <div class="form-group">
                              <label for="email">Email</label>
                              <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" tabindex="1" required autofocus>
                              @if ($errors->has('email'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                              @endif
                            </div>

                            <div class="form-group">
                              <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                                <div class="float-right">
                                  <a href="{{ url('password/reset') }}" class="text-small">
                                    Forgot Password?
                                  </a>
                                </div>
                              </div>
                              <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" tabindex="2" required>
                              @if ($errors->has('password'))
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                              @endif
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-group">
                                      <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                </div>
                            </div>

                            <div class="form-group m-t-10 mb-0 row">
                                <div class="col-sm-7 m-t-20">
                                    <a href="{{ url('password/reset') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                </div>
                                <div class="col-sm-5 m-t-20">
                                    <a href="{{route('register')}}" class="text-muted"><i class="mdi mdi-account-circle"></i> Create an account</a>
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
