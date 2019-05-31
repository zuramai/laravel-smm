@extends('layouts.horizontal')
@section('pageTitle','Kontak Admin')
@section('content')
<div class="container-fluid">


<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title m-0">Kontak Staff</h4>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
          <div class="section-body">
            <p class="section-lead">
              Anda dapat menghubungi admin untuk mendaftar, isi saldo, atau bertanya sesuatu.
            </p>

            <div class="row mt-sm-4">
                @foreach($staff as $data)
              
                <div class="col-md-6">
                  <div class="card">
                      <div class="card-body">
                          
                          <div class="text-center">
                              <div class="social-source-icon lg-icon mb-3">
                                  <img src="{{asset('img/staff/'.$data->picture)}}" class="img-setting">
                              </div>
                              <h5 class="font-16"><a href="#" class="text-dark">{{$data->name}} - <span class="text-muted">{{$data->level}}</span> </a></h5>
                          </div>
                          <div class="row mt-5">
                              <div class="col-md-4">
                                <a href="{{$data->facebook_url}}">
                                  <div class="social-source text-center mt-3">
                                      <div class="social-source-icon mb-2">
                                          <i class="mdi mdi-facebook h5 bg-primary text-white"></i>
                                      </div>
                                      <p class="font-14 text-muted mb-2">{{$data->facebook_name}}</p>
                                      <h6>Facebook</h6>
                                  </div>
                                </a>
                              </div>
                              <div class="col-md-4">
                                    <a href="https://api.whatsapp.com/send?phone={{'62'.substr($data->phone,1,15)}}&text=Halo admin ">
                                      <div class="social-source text-center mt-3">
                                          <div class="social-source-icon mb-2">
                                              <i class=" mdi mdi-whatsapp  h5 bg-info text-white"></i>
                                          </div>
                                          <p class="font-14 text-muted mb-2">{{$data->phone}}</p>
                                          <h6>Whatsapp</h6>
                                      </div>
                                    </a>
                                
                              </div>
                              <div class="col-md-4">
                                    <a href="mailto:someone@example.com?Subject=Hello%20again">
                                      <div class="social-source text-center mt-3">
                                          <div class="social-source-icon mb-2">
                                              <i class=" mdi mdi-gmail  h5 bg-danger text-white"></i>
                                          </div>
                                          <p class="font-14 text-muted mb-2">{{$data->email}}</p>
                                          <h6>Email</h6>
                                          
                                      </div>
                                    </a>
                              </div>
                          </div>
                          
                      </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </section>


</div>
@endsection