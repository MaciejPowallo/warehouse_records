<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Maciej Powallo">
        <meta name="description" content="Darmowy program do obsługi magazynu">

    <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
        <title>@yield('title')</title>

    <!-- CSS -->
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('css/main.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">

    <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>  
    </head>

    <body class="image_bg">
        <div class="container mb">
            <header>
                <a href="{{ URL::asset('index.php') }}"><img src="{{asset('images/logo.png')}}" alt="" class="img-responsive logo"></a>
            </header>
                
            <article class="col-xs-12 container">
                <div class=" row centered site-content">                
                    @yield('content')
                </div>
            </article>
        </div>

        <footer class="pos_footer col-xs-12">
                <div class="container">
                    <div class="row text-center">
                        <p class="log_footer">Warehouse Records 2017 <sup>&#174;</sup></p>    
                    </div>
                </div>
        </footer>
    </body>
</html>
