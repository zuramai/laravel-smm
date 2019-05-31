<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adalah sebuah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia. Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll. Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.">

    <link rel="shortcut icon" href="{{config('web_config')['WEB_FAVICON_URL']}}">

    <title>{{config('web_config')['APP_NAME']}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('landing-page/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- simpletextrotator.css -->
    <link rel="stylesheet" href="{{asset('landing-page/css/simpletextrotator.css')}}">

    <link href="{{asset('landing-page/css/icons.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('landing-page/css/style.css')}}" rel="stylesheet">



</head>


<body style="padding-top: 50px;">

    <nav class="navbar navbar-expand-lg fixed-top navbar-default navbar-light navbar-custom sticky">
        <div class="container">
            <!-- LOGO -->
            <a class="navbar-brand logo" href="{{ url('/') }}/index.php">
                <h1>{{ config('web_config')['APP_NAME'] }}</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="nav navbar-nav ml-auto navbar-center" id="mySidenav">
                    <li class="nav-item">
                        <a href="#home" class="nav-link scroll">Halaman Utama</a>
                    </li>
                    <li class="nav-item">
                        <a href="#features" class="nav-link scroll">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link scroll">Tentang Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <section class="section-lg home-alt bg-solid-1" id="home">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="home-wrapper text-center">
                        <p class="text-muted">Social Media Marketing</p>
                        <h1 class="text-rotate">{{ config('web_config')['APP_NAME'] }} SMM PANEL,Website Penyedia Layanan Social Media Terbaik Dan Harga Termurah.
</h1>

                        <a href="{{ url('/login') }}" class="btn btn-white">Masuk</a> 
                        <a href="{{ url('/register') }}" class="btn btn-white">Daftar</a> 
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="facts-box text-center">
                        <div class="row">
                            <div class="col-sm-4 col-6">
                                <h2>{{$total_layanan}}</h2>
                                <p class="text-muted">Layanan</p>
                            </div>

                            <div class="col-sm-4 col-6">
                                <h2>{{$total_pengguna}}</h2>
                                <p class="text-muted">Pengguna</p>
                            </div>

                            <div class="col-sm-4 col-6">
                                <h2>{{ $total_pesanan }}</h2>
                                <p class="text-muted">Pesanan</p>
                            </div>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="clearfix"></div>


    <section class="section" id="features">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="features-box text-center">
                        <div class="feature-icon">
                            <i class="pe-7s-science"></i>
                        </div>
                        <h3>Layanan Berkualitas</h3>

                        <p class="text-muted">Kami selalu mengutamakan kualitas terbaik untuk layanan yang kami sediakan demi kepercayaan client.</p>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="features-box text-center">
                            <div class="feature-icon">
                                <i class="pe-7s-light"></i>
                            </div>
                            <h3>Pelayanan Bantuan</h3>

                            <p class="text-muted">Kami selalu mengutamakan kepuasan client dengan cara memberikan pelayanan terbaik.</p>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="features-box text-center">
                            <div class="feature-icon">
                                <i class="pe-7s-display1"></i>
                            </div>
                            <h3>Desain Clean & Responsive</h3>

                            <p class="text-muted">Website kami dapat diakses melalui berbagai device/perangkat baik PC, tablet, maupun mobile phone.</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>







        <section class="section bg-white" id="about">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2 class="title">Tentang Kami</h2>
                        <p class="title-alt"> {{ config('web_config')['APP_NAME'] }} SMM adalah sebuah platform bisnis yang menyediakan berbagai layanan social media marketing yang bergerak terutama di Indonesia.<br>
                            Dengan bergabung bersama kami, Anda dapat menjadi penyedia jasa social media atau reseller social media seperti jasa penambah Followers, Likes, dll.<br>
                        Saat ini tersedia berbagai layanan untuk social media terpopuler seperti Instagram, Facebook, Twitter, Youtube, dll.</p>
                        <div class="text-center">
                            <a href="{{ url('/login') }}" class="btn btn-dark">Masuk</a> 
                            <a href="{{ url('/register') }}" class="btn btn-dark">Daftar</a> 
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="footer bg-dark">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <p class="copyright">{{ config('web_config')['APP_NAME'] }} © 2018 . Design by <a href="{{ url('/') }}/">{{ config('web_config')['APP_NAME'] }}</a></p>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end container -->
        </footer>


        <!-- js placed at the end of the document so the pages load faster -->
        <script src="{{asset('landing-page/js/jquery.min.js')}}"></script>
        <script src="{{asset('landing-page/js/bootstrap.bundle.min.js')}}"></script>
        <!-- Jquery easing -->                                                      
        <script type="text/javascript" src="js/jquery.easing.min.js')}}"></script>
        <script src="{{asset('landing-page/js/jquery.simple-text-rotator.min.js')}}"></script>

        <!--common script for all pages-->
        <script src="{{asset('landing-page/js/jquery.app.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $(".text-rotate").textrotator({
                    animation: "flipUp",
                    speed: 3000
                });
            });
        </script>

    </body>
</html>