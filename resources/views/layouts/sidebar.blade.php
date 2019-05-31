<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{config('web_config')['APP_NAME']}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('modules/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('modules/owlcarousel2/dist/assets/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('modules/owlcarousel2/dist/assets/owl.theme.default.min.css')}}">
  <link rel="shortcut icon" type="text/css" href="{{ config('web_config')['WEB_FAVICON_URL'] }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/components.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">


<!-- /END GA --></head>
<script type="text/javascript" >
  
</script>
<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
          <ul class="navbar-nav mr-auto">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
        
        <ul class="navbar-nav navbar-right">
          
          @if(Auth::check())
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Berita
                  
              </div>
              <div class="dropdown-list-content dropdown-list-icons">
                @foreach(config('news') as $news)
                <a href="{{ url('/news') }}" class="dropdown-item">
                    @if($news->type == 'Info')
                    <div class="dropdown-item-icon bg-info text-white">
                      <i class="fas fa-bell"></i>
                    @elseif($news->type == 'Service')
                    <div class="dropdown-item-icon bg-success text-white">
                      <i class="fas fa-file-invoice   "></i>
                    @elseif($news->type == 'Maintenance')
                    <div class="dropdown-item-icon bg-danger text-white">
                      <i class="fas fa-exclamation-triangle"></i>
                    @else
                    <div class="dropdown-item-icon bg-primary text-white">
                      <i class="fas fa-info"></i>
                    @endif
                  </div>
                  <div class="dropdown-item-desc">
                    {{$news->title}}
                    <div class="time">{{$news->created_at->diffForHumans()}}</div>
                  </div>
                </a>
                @endforeach
              </div>
              <div class="dropdown-footer text-center">
                <a href="{{ url('/news') }}">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('img/users/'.auth()->user()->photo)}}" class="rounded-circle mr-1 img-header">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Logged in 
                {{config('last_login')->created_at->diffForHumans()}}
              </div>
              <a href="{{ url('/activity') }}" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Activities
              </a>
              <a href="{{url('/users/settings')}}" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Settings
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </div>
          </li>
          @endif
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{ url('/') }}">
                <img src='{{ config("web_config")["WEB_LOGO_URL"] }}' style='width: 150px'>
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">St</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main navigation</li>
            @guest
            <li><a class="nav-link" href="/"><i class="fas fa-sign-in-alt"></i> <span>Login</span></a></li>
            @else
            <li><a class="nav-link" href="/"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
            @if(auth()->user()->level == 'Developer')
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-unlock-alt "></i> <span>Developer Menu</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('developer/users')}}">Kelola Pengguna</a></li>
                <li><a class="nav-link" href="{{url('developer/orders/sosmed')}}"> Kelola Pesanan Sosmed</a></li>
                <li><a class="nav-link" href="{{url('developer/orders/pulsa')}}"> Kelola Pesanan Pulsa</a></li>
                <li><a class="nav-link" href="{{route('services_cat')}}"> Kelola Kategori Sosmed</a></li>
                <li><a class="nav-link" href="{{route('services_cat_pulsa')}}"> Kelola Kategori Pulsa</a></li>
                <li><a class="nav-link" href="{{route('dev_services')}}"> Kelola Layanan Sosmed</a></li>
                <li><a class="nav-link" href="{{route('dev_services_pulsa')}}"> Kelola Layanan Pulsa</a></li>
                <li><a class="nav-link" href="{{url('developer/deposit')}}"> Kelola Deposit</a></li>
                <li><a class="nav-link" href="{{url('developer/deposit/method')}}"> Kelola Metode Deposit</a></li>
                <li><a class="nav-link" href="{{url('developer/news')}}"> Kelola Berita</a></li>
                <li><a class="nav-link" href="{{url('developer/ticket')}}"> Kelola Tiket</a></li>
                <li><a class="nav-link" href="{{url('developer/providers')}}"> Kelola Provider</a></li>
                <li><a class="nav-link" href="{{url('developer/staff')}}"> Kelola Staff</a></li>
                <li><a class="nav-link" href="{{url('developer/invitation_code')}}"> Kelola Kode Undangan</a></li>
                <li><a class="nav-link" href="{{url('developer/activity')}}"> Log Aktifitas</a></li>
                
              </ul>
            </li>
            @endif
            @if(auth()->user()->level != 'Member')
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-unlock-alt "></i> <span>Staff Menu</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('staff/add_user')}}"> Tambah User</a></li>
                <li><a class="nav-link" href="{{url('staff/voucher')}}"> Kode Voucher</a></li>
              </ul>
            </li>
            @endif
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> <span>Sosial Media</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('order_sosmed')}}">Pemesanan baru</a></li>
                <li><a class="nav-link" href="{{route('sosmed_history')}}"> Riwayat Pemesanan</a></li>
                <!-- <li><a class="nav-link" href="{{url('order/sosmed/statistic')}}">Statistik Order</a></li> -->
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-shopping-cart"></i> <span>Pulsa & PPOB</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{route('order_pulsa')}}">Pemesanan baru</a></li>
                <li><a class="nav-link" href="{{route('order_pulsa_history')}}"> Riwayat Pemesanan</a></li>
                <!-- <li><a class="nav-link" href="{{url('order/statistic')}}">Statistik Order</a></li> -->
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-fire"></i> <span>Lainnya</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('news')}}">Berita</a></li>
                <li><a class="nav-link" href="{{url('hall_of_fame')}}">Top 10</a></li>
                <li><a class="nav-link" href="{{url('activity')}}"> Riwayat Aktifitas</a></li>
                <li><a class="nav-link" href="{{url('balance_usage')}}">Penggunaan Saldo</a></li>
                <li><a class="nav-link" href="{{url('voucher')}}">Kode Voucher</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ url('ticket') }}" class="nav-link " ><i class="fas fa-envelope"></i> <span>Tiket</span></a>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-dollar-sign "></i> <span>Deposit</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('deposit/new')}}">Deposit Baru</a></li>
                <li><a class="nav-link" href="{{url('deposit/history')}}">Riwayat Deposit</a></li>
              </ul>
            </li>
            @endauth
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tag"></i> <span>Daftar layanan</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ url('price/sosmed') }}">Sosial Media</a></li>
                <li><a class="nav-link" href="{{ url('price/pulsa') }}">Pulsa & PPOB</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-random"></i> <span>API Dokumentasi</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{url('api/sosmed/doc')}}">Sosial Media</a></li>
                <li><a class="nav-link" href="{{url('api/pulsa/doc')}}">Pulsa & PPOB</a></li>
              </ul>
            </li>
            <li><a href="{{ url('/contact') }}" class="nav-link"><i class="fas fa-users"></i><span>Kontak Admin</span></a></li>
            @auth
            <li><a href="{{ url('/users/settings') }}" class="nav-link"><i class="fas fa-cogs"></i><span>Settings</span></a></li>
            @endauth

        
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; {{date('Y')}} <div class="bullet"></div> Build with ♥ by <a href="https://www.zuramai.net/">Zuramai Network</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>
  <!-- Modal -->
 
  <!-- General JS Scripts -->
  <script src="{{asset('modules/jquery.min.js')}}"></script>
  <script src="{{asset('modules/popper.js')}}"></script>
  <script src="{{asset('modules/tooltip.js')}}"></script>
  <script src="{{asset('modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('modules/moment.min.js')}}"></script>
  <script src="{{asset('js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{asset('modules/jquery.sparkline.min.js')}}"></script>
  <script src="{{asset('modules/chart.min.js')}}"></script>
  <script src="{{asset('modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
  <script src="{{asset('modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

@if(url()->current() == url('/') || url()->current() == url('/') || url()->current() == url('/home'))
  <script type="text/javascript">
    var data_sosmed = new Array(0,0,0,0,0,0,0,0,0,0,0,0)
    @foreach($order_sosmed as $sosmed)

    data_sosmed[{{$sosmed->month}}] = {{$sosmed->total}}
    @endforeach

    var data_pulsa = new Array(0,0,0,0,0,0,0,0,0,0,0,0)
    @foreach($order_pulsa as $pulsa)

    data_pulsa[{{$pulsa->month}}] = {{$pulsa->total}}
    @endforeach

    console.log(data_pulsa)
  </script>
@endif

  <!-- Page Specific JS File -->
  
  <script src="{{asset('js/page/index.js')}}"></script>
  <script src="{{asset('modules/sweetalert/sweetalert.min.js')}}"></script>
  @include('sweet::alert')
  <!-- Template JS File -->
  <script src="{{asset('js/scripts.js')}}"></script>
  <script src="{{asset('js/function.js')}}"></script>
  <script src="{{asset('js/custom.js')}}"></script>
  <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  
  <script type="text/javascript">
        


  $(document).ready(function(){
    var csrf_token = $("meta[name='csrf-token']").attr('content');
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
  })
        


           
        
    </script>
</body>
</html>