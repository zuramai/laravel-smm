@extends('layouts.errors')
@section('pageTitle','500')
@section('content')
<div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card">
                            <div class="card-block">
            
                                <div class="ex-page-content text-center">
                                    <h1 class="text-primary">500</h1>
                                    <h4 class="">Whoops! Something went wrong</h4><br>
            
                                    <a class="btn btn-primary mb-5 waves-effect waves-light" href="{{ url('/') }}">Back to home</a>
                                </div>
            
                            </div>
                        </div>
                                            
                    </div>
                </div>
                <!-- end row -->
            </div>
@endsection