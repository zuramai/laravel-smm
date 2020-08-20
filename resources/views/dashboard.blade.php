@extends('layouts.horizontal')

@section('content')
<div class="container-fluid">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h4 class="page-title m-0">Dashboard</h4>
                                            </div>
                                            <!-- end col -->
                                        </div>
                                        <!-- end row -->
                                    </div>
                                    <!-- end page-title-box -->
                                </div>
                            </div> 
                            <!-- end page title -->

                            <div class="row">
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">Order bulan ini</h6>
                                                <h4 class="mb-3 mt-0 float-right">{{$total_order_thismo}}</h4>
                                            </div>
                                            <div>
                                                <span class="badge badge-light text-info"> +{{$order_percentage}}% </span> <span class="ml-2">Dari Bulan Kemarin</span>
                                            </div>
                                            
                                        </div>
                                        <div class="p-3">
                                            <div class="float-right">
                                                <a href="#" class="text-white-50"><i class=" mdi mdi-cart h5"></i></a>
                                            </div>
                                            <p class="font-14 m-0">Bulan lalu : {{$total_order_lastmo}}</p>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-info mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">Saldo</h6>
                                                <h4 class="mb-3 mt-0 float-right">{{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($user->balance)}}</h4>
                                            </div>
                                            <div>
                                                <a href="{{ url('balance_usage') }}" class="text-white">Lihat Riwayat Saldo</a>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="float-right">
                                                <a href="#" class="text-white-50"><i class="fas fa-dollar-sign h5"></i></a>
                                            </div>
                                            @if(empty($last_used_balance->created_at))
                                            <p class="font-14 m-0">Belum pernah transaksi</p>
                                            @else
                                            <p class="font-14 m-0">Terakhir order : {{ Carbon\Carbon::parse($last_used_balance->created_at)->format('Y-m-d') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-pink mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">Penggunaan</h6>
                                                <h4 class="mb-3 mt-0 float-right">{{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($used_balance)}}</h4>
                                            </div>
                                            <div>
                                                <span class="badge badge-light text-primary"> {{Numberize::make($balance_percentage,2)}}% </span> <span class="ml-2">Dari bulan lalu</span>
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="float-right">
                                                <a href="#" class="text-white-50"><i class=" mdi mdi-cart "></i></a>
                                            </div>
                                            @if(empty($last_used_balance->created_at))
                                            <p class="font-14 m-0">Belum pernah transaksi</p>
                                            @else
                                            <p class="font-14 m-0">Terakhir penggunaan: {{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($last_used_balance->quantity)}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-success mini-stat text-white">
                                        <div class="p-3 mini-stat-desc">
                                            <div class="clearfix">
                                                <h6 class="text-uppercase mt-0 float-left text-white-50">Order Dalam Proses</h6>
                                                <h4 class="mb-3 mt-0 float-right">{{$pendingprocessing}}</h4>
                                            </div>
                                            <div>
                                                <span class=""> Total Order: {{Numberize::make($total_order->count())}} </span> 
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <div class="float-right">
                                                <a href="#" class="text-white-50"><i class="mdi mdi-briefcase-check h5"></i></a>
                                            </div>
                                            <p class="font-14 m-0">Order Sukses : {{Numberize::make($success)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <!-- end row -->
            
                            <div class="row">
                                <div class="col-xl-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Statistik</h4>
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div id="morris-line-example" class="morris-chart" style="height: 300px"></div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div>
                                                        <h5 class="font-14 mb-5">Total Order Bulan Ini</h5>
            
                                                        <div>
                                                            <h5 class="mb-3">{{Carbon\Carbon::now()->format('F')}}: {{ config('web_config')['CURRENCY_CODE'] }} {{Numberize::make($balance_usage_thismo)}}</h5>
                                                            <p class="text-muted mb-4">Selamat datang di {{config('web_config')['APP_NAME']}}, Ini adalah statistik pembelian Anda, jika ada yang bingung baca panduan atau bisa <a href="{{url('/contact')}}">hubungi Admin</a>. Sukses selalu</p>
                                                            <a href="{{ url('order/sosmed') }}" class="btn btn-primary btn-sm">Pemesanan Baru <i class="mdi mdi-chevron-right"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Informasi akun</h4>
                                            <div class="image d-flex justify-content-center flex-column align-items-center">
                                                <img src="{{ asset('img/users/'.$user->photo) }}" class="img-setting" id="img-setting">
                                              </div>
                                              <div class="form mt-2">
                                                <form>
                                                  <div class="form-group">
                                                    <label for="fullname"><i class="fas fa-user"></i> Nama</label>
                                                    <input type="text" id="fullname" class="form-control-plaintext" value="{{ $user->name }}">
                                                  </div>
                                                  <div class="form-group">
                                                    <label><i class="fas fa-level-up-alt "></i> Level</label>
                                                    <input type="text" name="email" class="form-control-plaintext" value="{{ $user->level }}" readonly="">
                                                  </div>
                                                  <div class="form-group">
                                                    <label><i class="fas fa-dollar-sign "></i> Sisa Saldo</label>
                                                    <input type="text" name="email" class="form-control-plaintext" value="{{ config('web_config')['CURRENCY_CODE'] }} {{ Numberize::make($user->balance) }}" readonly="">
                                                  </div>
                                                </form>
                                                 
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
            
                           
                          
                           <!-- end row -->

                        </div><!-- container fluid -->
@endsection
@push('scripts')

    <script src="{{asset('plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
    <script type="text/javascript"> 
        
        function createLineChart(element, data, xkey, ykeys, labels, lineColors) {
            Morris.Line({
                element: element,
                data: data,
                xkey: xkey,
                ykeys: ykeys,
                labels: labels,
                hideHover: 'auto',
                gridLineColor: '#eef0f2',
                resize: true, //defaulted to true
                lineColors: lineColors
            });
        }
        var data = [  
            { y: "{{Carbon\Carbon::now()->subDays(6)->format('Y-m-d')}}", a: {{$sosmed['6_days_ago']}},b: {{$pulsa['6_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->subDays(5)->format('Y-m-d')}}", a: {{$sosmed['5_days_ago']}},b: {{$pulsa['5_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->subDays(4)->format('Y-m-d')}}", a: {{$sosmed['4_days_ago']}},b: {{$pulsa['4_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->subDays(3)->format('Y-m-d')}}", a: {{$sosmed['3_days_ago']}},b: {{$pulsa['3_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->subDays(2)->format('Y-m-d')}}", a: {{$sosmed['2_days_ago']}},b: {{$pulsa['2_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->subDays(1)->format('Y-m-d')}}", a: {{$sosmed['1_days_ago']}},b: {{$pulsa['1_days_ago']}}},
            { y: "{{Carbon\Carbon::now()->format('Y-m-d')}}", a: {{$sosmed['now']}},b: {{$pulsa['now']}}}
        ]
        createLineChart('morris-line-example', data, 'y', ['a', 'b'], ['Order Sosmed', 'Order Pulsa'], ['#5985ee', '#46cd93']);


    </script>
@endpush