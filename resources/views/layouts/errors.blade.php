<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>@yield('pageTitle') - {{ config('web_config')['APP_NAME'] }}</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App Icons -->
        <link rel="shortcut icon" href="{{config('web_config')['WEB_FAVICON_URL']}}">

        <!-- App css -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/icons.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />

    </head>


    <body>

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

        <div class="account-pages">
            
            @yield('content')
        </div>
    


        <!-- jQuery  -->
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('js/modernizr.min.js')}}"></script>
        <script src="{{asset('js/waves.js')}}"></script>
        <script src="{{asset('js/jquery.slimscroll.js')}}"></script>

        <!-- App js -->
        <script src="{{asset('js/app.js')}}"></script>

    </body>
</html>