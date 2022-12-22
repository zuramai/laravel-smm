@extends('layouts.auth')

@section('content')
<div class="container-fluid">
@section('app_title','Reset - '.config('web_config')['APP_NAME'])

<div class="container">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <div>
                <div >
                    <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                </div>
                {!! config('web_config')['WEB_AUTH_DESCRIPTION'] !!}
            </div>
        </div>
        <div class="col-lg-5 offset-lg-1">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="text-center">
                        <div>
                            <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                        </div>
                        <h4 class="text-muted font-18 mt-4">Reset Password</h4>
                    </div>

                    <div class="p-2">
                        <form class="form-horizontal m-t-20" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="alert alert-primary alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                Masukkan <b>Email</b> dan instruksi akan dikirimkan ke emailmu!
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group text-center row m-t-20">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Send Email</button>
                                </div>
                            </div>

                        </form>
                        <!-- end form -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
  </div>
</div>
@endsection


