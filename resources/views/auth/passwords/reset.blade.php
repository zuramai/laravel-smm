@extends('layouts.auth')

@section('content')
@section('app_title','Login - '.config('web_config')['WEB_TITLE'])
<div class="container-fluid">

<div class="container">
  <div class="row align-items-center">
      <div class="col-lg-12 ">
          <div class="card mb-0">
              <div class="card-body">
                  <div class="p-2">
                      <h4 class="text-muted float-right font-18 mt-4">Reset Password</h4>
                      <div>
                          <a href="{{ url('/') }}" class="logo logo-admin"><img src="{{config('web_config')['WEB_LOGO_URL_DARK']}}" height="28" alt="logo"></a>
                      </div>
                  </div>

                  <div class="p-2">
                       @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a>.
                  </div>

              </div>
          </div>
      </div>
  </div>
  <!-- end row -->
</div>
</div>
@endsection


