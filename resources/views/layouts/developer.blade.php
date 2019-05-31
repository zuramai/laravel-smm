<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Developer Menu - {{config('web_config')['APP_NAME']}}</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- morris css -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">

        <link href="{{asset('plugins/sweet-alert2/sweetalert2.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('plugins/summernote/summernote-bs4.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">

    </head>


    <body class="fixed-left">

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

        <!-- Begin page -->
        <div id="wrapper">

            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="mdi mdi-close"></i>
                </button>

                <div class="left-side-logo d-block d-lg-none">
                    <div class="text-center">
                        
                        <a href="{{ url('/') }}" class="logo"><img src="{{config('web_config')['WEB_LOGO_URL']}}" height="20" alt="logo"></a>
                        <a href="{{ url('/') }}" class="logo">{{config('web_config')['APP_NAME']}}</a>
                    </div>
                </div>

                <div class="sidebar-inner slimscrollleft">
                    
                    <div id="sidebar-menu">
                        <ul>
                            <li class="menu-title">Developer Menu</li>

                            <li>
                                <a href="{{ url('/home') }}" class="waves-effect">
                                    <i class="dripicons-home"></i>
                                    <span> Halaman Utama </span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/developer') }}" class="waves-effect">
                                    <i class=" dripicons-graph-bar "></i>
                                    <span> Statistik</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/users') }}" class="waves-effect">
                                    <i class=" dripicons-user "></i>
                                    <span> Kelola Pengguna</span>
                                </a>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class=" dripicons-network-3 "></i> <span> Sosial Media</span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="nav-link" href="{{url('developer/orders/sosmed')}}"> Kelola Pesanan Sosmed</a></li>
                                    <li><a class="nav-link" href="{{route('dev_services')}}"> Kelola Layanan Sosmed</a></li>
                                    <li><a class="nav-link" href="{{route('services_cat')}}"> Kelola Kategori Sosmed</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-cart"></i> <span> Pulsa & PPOB </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="nav-link" href="{{url('developer/orders/pulsa')}}"> Kelola Pesanan Pulsa</a></li>
                                    <li><a class="nav-link" href="{{route('dev_services_pulsa')}}"> Kelola Layanan Pulsa</a></li>
                                    <li><a class="nav-link" href="{{route('services_cat_pulsa')}}"> Kelola Kategori Pulsa</a></li>
                                </ul>
                            </li>
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-wallet"></i><span> Deposit </span> <span class="menu-arrow float-right"><i class=" mdi mdi-chevron-right"></i></span></a>
                                <ul class="list-unstyled">
                                    <li><a class="nav-link" href="{{url('developer/deposit')}}"> Semua Deposit</a></li>
                                    <li><a class="nav-link" href="{{url('developer/deposit/method')}}"> Kelola Metode Deposit</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ url('developer/news') }}" class="waves-effect">
                                    <i class="  dripicons-document  "></i>
                                    <span> Kelola Berita</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/ticket') }}" class="waves-effect">
                                    <i class="  dripicons-message  "></i>
                                    <span> Kelola Tiket</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/providers') }}" class="waves-effect">
                                    <i class=" dripicons-toggles "></i>
                                    <span> Kelola Provider</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/staff') }}" class="waves-effect">
                                    <i class=" dripicons-user "></i>
                                    <span> Kelola Staff</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/invitation_code') }}" class="waves-effect">
                                    <i class="  dripicons-mail  "></i>
                                    <span> Kelola Kode Undangan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('developer/activity') }}" class="waves-effect">
                                    <i class=" dripicons-user "></i>
                                    <span> Log Aktifitas</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div> <!-- end sidebarinner -->
            </div>
            <!-- Left Sidebar End -->

            <!-- Start right Content here -->

            <div class="content-page">
                <!-- Start content -->
                <div class="content">

                    <!-- Top Bar Start -->
                    <div class="topbar">

                        <div class="topbar-left d-none d-lg-block">
                            <div class="text-center">
                                <!-- <a href="{{ url('/') }}" class="logo">LARAVEL-SMM V2</a> -->
                                <a href="{{ url('/') }}" class="logo"><img src="{{config('web_config')['WEB_LOGO_URL']}}" height="25" alt="{{config('web_config')['APP_NAME']}}"></a>
                            </div>
                        </div>

                        <nav class="navbar-custom">

                             <!-- Search input -->
                             <div class="search-wrap" id="search-wrap">
                                <div class="search-bar">
                                    <input class="search-input" type="search" placeholder="Search" />
                                    <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                        <i class="mdi mdi-close-circle"></i>
                                    </a>
                                </div>
                            </div>

                            <ul class="list-inline float-right mb-0">
                                <li class="list-inline-item dropdown notification-list">
                                    <a class="nav-link waves-effect toggle-search" href="#"  data-target="#search-wrap">
                                        <i class="mdi mdi-magnify noti-icon"></i>
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
                                            <h5>Notification (3)</h5>
                                        </div>

                                        <div class="slimscroll-noti">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item active">
                                                <div class="notify-icon bg-success"><i class="mdi mdi-cart-outline"></i></div>
                                                <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                            </a>

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-danger"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                            </a>

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-info"><i class="mdi mdi-filter-outline"></i></div>
                                                <p class="notify-details"><b>Your item is shipped</b><span class="text-muted">It is a long established fact that a reader will</span></p>
                                            </a>

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-success"><i class="mdi mdi-message-text-outline"></i></div>
                                                <p class="notify-details"><b>New Message received</b><span class="text-muted">You have 87 unread messages</span></p>
                                            </a>

                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                                <div class="notify-icon bg-warning"><i class="mdi mdi-cart-outline"></i></div>
                                                <p class="notify-details"><b>Your order is placed</b><span class="text-muted">Dummy text of the printing and typesetting industry.</span></p>
                                            </a>

                                        </div>
                                        

                                        <!-- All-->
                                        <a href="javascript:void(0);" class="dropdown-item notify-all">
                                            View All
                                        </a>

                                    </div>
                                </li>
    

                                <li class="list-inline-item dropdown notification-list nav-user">
                                    <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button"
                                    aria-haspopup="false" aria-expanded="false">
                                        <img src="{{asset('img/users/'.auth()->user()->photo)}}" alt="user" class="rounded-circle">
                                        <span class="d-none d-md-inline-block ml-1"> {{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i> </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                                        <a class="dropdown-item" href="#"><i class="dripicons-user text-muted"></i> Profile</a>
                                        <a class="dropdown-item" href="#"><i class="dripicons-wallet text-muted"></i> My Wallet</a>
                                        <a class="dropdown-item" href="#"><span class="badge badge-success float-right m-t-5">5</span><i class="dripicons-gear text-muted"></i> Settings</a>
                                        <a class="dropdown-item" href="#"><i class="dripicons-lock text-muted"></i> Lock screen</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="dripicons-exit text-muted"></i> Logout</a>
                                    </div>
                                </li>

                            </ul>

                            <ul class="list-inline menu-left mb-0">
                                <li class="list-inline-item">
                                    <button type="button" class="button-menu-mobile open-left waves-effect">
                                        <i class="mdi mdi-menu"></i>
                                    </button>
                                </li>
                                <li class="list-inline-item dropdown notification-list d-none d-sm-inline-block">
                                  
                                    <div class="dropdown-menu dropdown-menu-animated">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                </li>
                               

                            </ul>


                        </nav>

                    </div>
                    <!-- Top Bar End -->

                    <div class="page-content-wrapper ">

                        @yield('content')

                    </div> <!-- Page content Wrapper -->

                </div> <!-- content -->

                <footer class="footer">
                    © 2019 {{config('web_config')['APP_NAME']}} <span class="d-none d-md-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by <a href="https://www.zuramai.net">Zuramai Network</a>.</span>
                </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


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
        <!--Morris Chart-->
        <script src="{{asset('plugins/morris/morris.min.js')}}"></script>
        <script src="{{asset('plugins/raphael/raphael.min.js')}}"></script>
        <script src="{{asset('plugins/summernote/summernote-bs4.js')}}"></script>

        <!-- dashboard js -->
        <script src="{{asset('pages/dashboard.int.js')}}"></script>        

        <!-- App js -->
        <script src="{{asset('js/app.js')}}"></script>
        <script src="{{asset('js/custom.js')}}"></script>

    </body>
</html>