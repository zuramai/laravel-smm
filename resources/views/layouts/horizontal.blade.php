<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{config('web_config')['WEB_TITLE']}}</title>
        <meta content="{{ config('web_config')['WEB_DESCRIPTION'] }}" name="description" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link rel="shortcut icon" href="{{config('web_config')['WEB_FAVICON_URL']}}">


        <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
        <link href="{{asset('plugins/sweet-alert2/sweetalert2.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">

    </head>


    <body >

        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
        </div>
        <div class="header-bg">
            <!-- Navigation Bar-->
            <header id="topnav">
                <div class="topbar-main">
                    <div class="container-fluid">

                        <!-- Logo-->
                        <div>
                            
                            <a href="{{ url('/') }}" class="logo">
                                <span data-favicon='{{ config("web_config")["WEB_FAVICON_URL"] }}'></span>
                                <img src="{{config('web_config')['WEB_LOGO_URL']}}" height="26" alt="logo" id="logo-top">
                            </a>

                        </div>
                        <!-- End Logo-->
                        @auth
                        <div class="menu-extras topbar-custom navbar p-0">


                            <!-- Search input -->
                            <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline ml-auto mb-0">
                                
                                <!-- notification-->

                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        Rp {{number_format(auth()->user()->balance)}}
                                    </a>
                                </li>

                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        <i class="mdi mdi-bell-outline noti-icon"></i>
                                        <span class="badge badge-danger badge-pill noti-icon-badge">3</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg dropdown-menu-animated">
                                        <!-- item-->
                                        <div class="dropdown-item noti-title">
                                            <h5>Berita</h5>
                                        </div>

                                        <div class="slimscroll-noti">
                                            <!-- item-->
                                            @foreach(config('news') as $news)
                                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                                @if($news->type == 'Info')
                                                <div class="notify-icon bg-success"><i class="dripicons-bell"></i></div>
                                                @elseif($news->type == 'Service')
                                                <div class="notify-icon bg-info"><i class="dripicons-bell"></i></div>
                                                @elseif($news->type == 'Maintenance')
                                                <div class="notify-icon bg-danger"><i class="fas fa-exclamation-circle"></i></div>
                                                @else
                                                <div class="notify-icon bg-warning"><i class="mdi mdi-cart-outline"></i></div>
                                                @endif
                                                <p class="notify-details"><b>{{$news->title}}</b><span class="text-muted">{{substr($news->content,0,30)}}..</span></p>
                                            </a>
                                            @endforeach


                                        </div>
                                        

                                        <!-- All-->
                                        <a href="{{url('news')}}" class="dropdown-item notify-all">
                                            Lihat semua
                                        </a>

                                    </div>
                                </li>
                                <!-- User-->
                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('img/users/'.auth()->user()->photo)}}"  alt="user" class="rounded-circle img-top-user">
                                        <span class="d-none d-md-inline-block ml-1"> {{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i> </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                        <a class="dropdown-item" href="{{url('ticket')}}"><i class=" dripicons-ticket  text-muted"></i> Tiket Saya 
                                            @if(config('unread_ticket_user') != 0)
                                            <span class="badge badge-primary">{{ config('unread_ticket_user') }}</span>
                                            @endif
                                        </a>
                                        <a class="dropdown-item" href="{{url('users/settings')}}"><i class="dripicons-gear text-muted"></i> Settings</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="dripicons-exit text-muted"></i> Logout</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              @csrf
                                          </form>
                                    </div>
                                </li>
                                <li class="menu-item list-inline-item">
                                    <!-- Mobile menu toggle-->
                                    <a class="navbar-toggle nav-link">
                                        <div class="lines">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <!-- End mobile menu toggle-->
                                </li>

                            </ul>
                        </div>
                        @endauth
                        <!-- end menu-extras -->

                        <div class="clearfix"></div>

                    </div> <!-- end container -->
                </div>
                <!-- end topbar-main -->

                <!-- MENU Start -->
                <div class="navbar-custom">
                    <div class="container-fluid">
                        
                        <div id="navigation">

                            <!-- Navigation Menu-->
                            <ul class="navigation-menu">

                                @auth
                                <li class="has-submenu">
                                    <a href="{{ url('/home') }}"><i class="dripicons-home"></i> Dashboard</a>
                                </li>
                                @if(Auth::user()->level == 'Developer')
                                <li class="has-submenu">
                                    <a href="{{ url('/developer') }}"><i class="dripicons-lock-open"></i> Developer Page</a>
                                </li>
                                @endif
                                @if(Auth::user()->level != 'Member')
                                <li class="has-submenu">
                                    <a href="#"><i class="dripicons-suitcase"></i> Staff Menu <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu ">
                                        <li>
                                            <ul>
                                                <li><a href="{{url('staff/add_user')}}"> Tambah User</a></li>
                                                <li><a href="{{url('staff/voucher')}}"> Kode Voucher</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                @endif
                                <li class="has-submenu">
                                    <a href="#"><i class="dripicons-cart"></i> Order <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                        <li class="has-submenu">
                                            <a href="#">Sosial Media</a>
                                            <ul class="submenu">
                                                <li><a href="{{route('order_sosmed')}}">Pemesanan Baru</a></li>
                                                <li><a href="{{route('order_sosmed_mass')}}">Order Masal</a></li>
                                                <li><a href="{{route('sosmed_history')}}">Riwayat Pemesanan</a></li>
                                            </ul>
                                        </li>
                                        <li class="has-submenu">
                                            <a href="#">Pulsa </a>
                                            <ul class="submenu">
                                                <li><a  href="{{route('order_pulsa')}}">Pemesanan baru</a></li>
                                                <li><a  href="{{route('order_pulsa_history')}}"> Riwayat Pemesanan</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"><i class="fas fa-dollar-sign"></i> Deposit <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu">
                                        <li><a href="{{url('deposit/new')}}">Deposit Baru</a></li>
                                        <li><a href="{{url('deposit/history')}}">Riwayat Deposit</a></li>
                                    </ul>
                                </li>

                                <li class="has-submenu">
                                    <a href="#"><i class="dripicons-duplicate"></i> Lainnya <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu ">
                                        <li>
                                            <ul>
                                                <li><a class="nav-link" href="{{url('news')}}">Berita</a></li>
                                                <li><a class="nav-link" href="{{url('hall_of_fame')}}">Top 10</a></li>
                                                <li><a class="nav-link" href="{{url('activity')}}"> Riwayat Aktifitas</a></li>
                                                <li><a class="nav-link" href="{{url('balance_usage')}}">Penggunaan Saldo</a></li>
                                                <li><a class="nav-link" href="{{url('voucher')}}">Kode Voucher</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                @else
                                <li class="has-submenu">
                                    <a href="{{ url('/home') }}"><i class="fas fa-sign-in-alt"></i> Masuk</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="{{ url('/home') }}"><i class="fas fa-user-plus"></i> Daftar</a>
                                </li>
                                @endauth

                                <li class="has-submenu">
                                    <a href="#"><i class=" dripicons-media-shuffle "></i> API @guest Dokumentasi @endguest<i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu ">
                                        <li>
                                            <ul>
                                                <li><a class="nav-link" href="{{ url('api/sosmed/doc') }}">Sosial Media</a></li>
                                                <li><a class="nav-link" href="{{ url('api/pulsa/doc') }}">Pulsa & PPOB</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li class="has-submenu">
                                    <a href="#"><i class=" dripicons-media-shuffle "></i> Daftar Layanan <i class="mdi mdi-chevron-down mdi-drop"></i></a>
                                    <ul class="submenu ">
                                        <li>
                                            <ul>
                                                <li><a class="nav-link" href="{{ url('price/sosmed') }}">Sosial Media</a></li>
                                                <li><a class="nav-link" href="{{ url('price/pulsa') }}">Pulsa & PPOB</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                            </ul>
                            <!-- End navigation menu -->
                        </div> <!-- end #navigation -->
                    </div> <!-- end container -->
                </div> <!-- end navbar-custom -->
            </header>
            <!-- End Navigation Bar-->

        </div>
        <!-- header-bg -->
        <!-- Begin page -->
        <div class="wrapper">
            @yield('content')
        </div>
        @auth
        <!-- END wrapper -->
         <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Berita Terbaru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body h-75">
                    <div class="table-responsive  overflow-y-scroll">
                        <table class="table table-striped">
                            <tr>
                                <th>Waktu</th>
                                <th>Tipe</th>
                                <th>Konten</th>
                            </tr>
                            @foreach(config('news') as $data_berita)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($data_berita->created_at)->format('d F Y H:i:s') }}</td>
                                <td>
                                    <span class="badge badge-{{ ($data_berita->type == 'Maintenance' ? 'danger' : ($data_berita->type == 'Info' ? 'info' : 'primary')) }}">
                                    {{ $data_berita->type }}
                                    </span>
                                </td>
                                <td><?php echo addslashes(nl2br($data_berita->content)) ?></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-center">
                                    <a href="{{ url('news') }}">Lihat Berita Lainnya</a>
                                </td>
                            </tr>
                        </table>
                    </div>  
                  <table>
                      
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-info" id="btn-read" data-dismiss="modal" ">Saya sudah membaca</button>
                </div>
              </div>
            </div>
          </div>
          @endauth
        <!-- jQuery  -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/modernizr.min.js')}}"></script>
        <script src="{{asset('js/detect.js')}}"></script>
        <script src="{{asset('js/fastclick.js')}}"></script>
        <script src="{{asset('js/jquery.slimscroll.js')}}"></script>
        <script src="{{asset('js/jquery.blockUI.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
        <script src="{{asset('js/jquery.scrollTo.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/sweetalert.min.js')}}"></script>
        <script src="{{asset('plugins/alertify/js/alertify.js')}}"></script>
        @include('sweet::alert')

        @if(url()->current() == url('/')  || url()->current() == url('/home'))
        <!--Morris Chart-->
        <script src="{{asset('plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
        <!-- dashboard js -->
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
        @endif
      <script type="text/javascript">
        @if(session('display_news') == 1)
          $('#exampleModal').modal('show')
        @endif
      </script>      
        <!-- App js -->
        <script src="{{asset('js/app.js')}}"></script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                var csrf_token = $("meta[name='csrf-token']").attr('content');
                var mq = window.matchMedia( "(max-width: 576px)" );
                if (mq.matches) {
                    $('#logo-top').attr('src', $("span").attr('data-favicon'))
                }
                $('#category').change(function(){
                    console.log('a')
                    var cat = $('#category').val();
                    $.ajax({
                        url: "{{url('order/sosmed/ajax/get_service')}}",
                        type: 'POST',
                        data: {
                            "_token": csrf_token,
                            "cat_id": cat
                        },
                        success:function(result){
                            $('#service').html(result)
                        }
                    }) 
                });
                $('#service').change(function(){
                    var service = $('#service').val();
                    $.ajax({
                        url: "{{url('order/sosmed/ajax/get_service_data')}}",
                        type: 'POST',
                        data: {
                            "_token": csrf_token,
                            "sid": service
                        },
                        success:function(result){
                            $('#information').html(result)
                        }
                    })
                    $.ajax({
                        url: "{{url('order/sosmed/ajax/get_price')}}",
                        type: 'POST',
                        data: {
                            "_token": csrf_token,
                            "sid": service
                        },
                        success:function(result){
                            $('#price').val(result)
                        }
                    })

                    $.ajax({
                      url: "{{url('order/sosmed/ajax/check_sosmed')}}",
                      type: 'POST',
                      data: {
                        "_token": csrf_token,
                        "sid": service
                      },
                      success: function(result) {
                        if(result == 'custom_comment') {
                          $('#custom_comment').css('display','block');
                          $('#quantity').attr('readonly','true');
                          $('#t_custom_comment').keyup(function() {
                            var text = $("#t_custom_comment").val();   
                            var lines = text.split(/\r|\r\n|\n/);
                            var count = lines.length;
                            $('#quantity').val(count);
                            var total = $('#price').val() / 1000 * count
                            $('#total').val(total);
                          });
                        }else if(result == 'likes_comment') {
                          $('#comment_likes').css('display','block');
                        }else{
                          $('#comment_likes').css('display','none');
                          $('#custom_comment').css('display','none');
                          $('#quantity').removeAttr('readonly');
                        }
                      }
                    });
                })
                $('#quantity').keyup(function(){
                    var qty = $('#quantity').val();
                    var price = $('#price').val();

                    var total = price/1000 * qty;

                    $('#total').val(total)
                })
                $('#cancel_deposit').click(function(){
                   
                  cancel_deposit($(this).attr('data-delete'));
                })

                $('#category_pulsa').change(function() {
                  var category = $('#category_pulsa').val();
                  var service = $('#service_pulsa');
                  var operator = $('#operator_pulsa');
                    // console.log("success");
                  $.ajax({
                    url: "{{url('order/pulsa/ajax/get_service_pulsa')}}",
                    type: 'POST',
                    data: {
                        "_token": csrf_token,
                        "id": category
                    },
                    success: function(result) {
                      operator.html(result)
                    }
                  });
                });

                $('#operator_pulsa').change(function() {
                  var category = $('#category_pulsa').val();
                  var operator = $('#operator_pulsa').val();
                  var service = $('#service_pulsa');

                  $.ajax({
                    url: "{{url('order/pulsa/ajax/get_type_pulsa')}}",
                    type: 'POST',
                    data: {
                        "_token": csrf_token,
                        "id": operator
                    },
                    success: function(result) {
                      service.html(result)
                    }
                  });
                });

                $('#service_pulsa').change(function() {
                  var service_pulsa = $('#service_pulsa').val();
                  var price = $('#total');
                  $.ajax({
                    url: "{{url('order/pulsa/ajax/get_price_pulsa')}}",
                    type: 'POST',
                    data: {
                        "_token": csrf_token,
                        "id": service_pulsa
                    },

                    success: function(result) {
                      price.val(result)
                    }

                  });
                });

                $('#type').change(function() {

                  var type = $('#type').val();
                  var method = $('#method');
                  var newType = "AUTO";
                  if(type == "Otomatis") 
                    newType = "AUTO"
                  else if(type == "Manual")
                    newType = "MANUAL"

                  $.ajax({
                    type: "POST",
                    url: "{{ url('deposit/get_method') }}",
                    data: {
                      "_token": csrf_token,
                      "type": newType
                    },
                    success:function(result) {
                      console.log(result);
                      method.html(result);
                    }
                  });
                });
                $('#method').change(function() {
                  var method = $('#method').val();
                  $.ajax({
                    url: "{{ url('deposit/get_rate') }}",
                    method: 'POST',
                    data: {
                      "_token": csrf_token,
                      "method": method
                    },
                    success:function(result) {
                      $('#rate_deposit').val(result);
                    }

                  })
                });

                $('#quantity_deposit').keyup(function() {
                  var quantity = $('#quantity_deposit').val();
                  var rate = $('#rate_deposit').val();
                  var get_balance = $('#get_balance'); 

                  var final = quantity * rate;
                  get_balance.val(final)
                }); 

                $('#btn-read').click(function(){
                    $.ajax({
                        url: "{{ url('read_news') }}",
                        method: 'POST',
                        data: {
                          "_token": csrf_token,
                          "read": true
                        }
                    });
                })
          })
        </script>
        <script src="{{asset('js/custom.js')}}"></script>

    </body>
</html>