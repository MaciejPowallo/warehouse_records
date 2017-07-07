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
        <link href="{{ URL::asset('css/print.css') }}" rel="stylesheet" type="text/css" media="print">
        <link href="{{ URL::asset('css/font-awesome.css') }}" rel="stylesheet" type="text/css">
        @yield('css')
    <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
            ]); ?>
        </script>  
    </head>


    <body id="page-top" class="index">
        <nav class="toolbar" >
            <div class="container">
                <ul>
                    <li>
                        <a class="logo_sm" href="{{ url('/home') }}"><img src="{{asset('images/logo_top.png')}}" alt="WR" class="img-responsive logo_sm"></a>
                    </li>
                    <li><a>Kontrahenci</a>
                        <ul>
                            <li><a href="{{ action('ContractorsController@index') }}">Wykaz kontrahentów</a></li>
                            <li><a href="{{ action('ContractorsController@create') }}">Dodaj kontrahenta</a></li>
                            <li><a href="{{ action('ContractorsDeleter@index') }}">Nieaktywni kontrahenci</a></li>
                        </ul>
                    </li>
                    <li><a>Pracownicy</a>
                        <ul>
                            <li><a href="{{ action('EmployeesController@index') }}">Wykaz pracowników</a></li>
                            <li><a href="{{ action('EmployeesController@create') }}">Dodaj procownika</a></li>
                            <li><a href="{{ action('EmployeesDeleter@index') }}">Wykaz zwolnionych</a></li>
                        </ul>
                    </li>
                    <li><a>Lokalizacje</a>
                        <ul>
                            <li><a href="{{ action('LocationsController@index') }}">Wykaz lokalizacji</a></li>
                            <li><a href="{{ action('LocationsController@create') }}">Dodaj lokalizację</a></li>
                            <li><a href="{{ action('LocationsDeleter@index') }}">Zamknięte lokalizacje</a></li>
                        </ul>
                    </li>
                    <li><a>Towary</a>
                        <ul>
                            <li class="txt-hover">Wyświetl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('ProductsController@index') }}">Wykaz produktów</a></li>
                            <li><a href="{{ action('GradesController@index') }}">Grupy produktów</a></li>  
                            <li><a href="{{ action('TypesController@index') }}">Rodzaje produktów</a></li> 
                            <li class="txt-hover">Dodaj&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('ProductsController@create') }}">Dodaj produkt</a></li>
                            <li><a href="{{ action('GradesController@create') }}">Dodaj grupę</a></li>                  
                            <li><a href="{{ action('TypesController@create') }}">Dodaj rodzaj</a></li>
                        </ul>
                    </li>
                    <li><a>Stany</a>
                        <ul>
                            <li><a href="{{ action('TotalQuantity@index') }}">Stan ogólny</a></li>
                            <li><a href="{{ action('WarehouseQuantity@index') }}">Stan magazynu</a></li>
                            <li><a href="{{ action('LiquidationQuantity@index') }}">Stan zliwidowanych</a></li>
                            <li><a href="{{ action('LocationQuantity@index') }}">Stany lokalizacji</a></li>
                            <li><a href="{{ action('EmployeeQuantity@index') }}">Stany pracowników</a></li>
                        </ul>
                    </li>
                    <li><a>Dokumenty</a>
                        <ul>
                            <li class="txt-hover">Wyświetl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('Wz_documentsApprover@index') }}">Wykaz wydań (WZ) </a></li>
                            <li><a href="{{ action('Pz_documentsApprover@index') }}">Wykaz przyjęć (PZ) </a></li>
                            <li><a href="{{ action('Zw_documentsApprover@index') }}">Wykaz zwrotów (ZW) </a></li>
                            <li><a href="{{ action('Lt_documentsApprover@index') }}">Wykaz likwidacji (LT) </a></li>
                            <li class="txt-hover">Dodaj&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('Wz_documentsController@create') }}">Dodaj wydanie (+ WZ) </a></li>
                            <li><a href="{{ action('Pz_documentsController@create') }}">Dodaj przyjęcie (+ PZ) </a></li>
                            <li><a href="{{ action('Zw_documentsController@create') }}">Dodaj zwrot (+ ZW) </a></li>
                            <li><a href="{{ action('Lt_documentsController@create') }}">Dodaj likwidację (+ LT) </a></li>
                        </ul>
                    </li>
                    <li><a>Rezerwacje</a>
                        <ul>
                            <li class="txt-hover">Wyświetl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('BookingsMediator@index') }}">Zatwierdzone</a></li>
                            <li><a href="{{ action('BookingsApprover@index') }}">W realizacji</a></li>
                            <li><a href="{{ action('BookingsController@index') }}">Niezatwierdzone</a></li>
                            <li class="txt-hover">Dodaj&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('BookingsController@create') }}">Nowa rezerwacja</a></li>              
                        </ul>
                    </li>
                    <li><a>Transporty</a>
                        <ul>
                            <li class="txt-hover">Wyświetl&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('Return_transportsMediator@index') }}">Zatwierdzone</a></li>
                            <li><a href="{{ action('Return_transportsApprover@index') }}">W realizacji</a></li>
                            <li><a href="{{ action('Return_transportsController@index') }}">Niezatwierdzone</a></li>
                            <li class="txt-hover">Dodaj&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
                            <li><a href="{{ action('Return_transportsController@create') }}">Nowy transport</a></li>          
                        </ul>
                    </li> 
                </ul>
            </div>
        </nav>



        <nav class="navbar navbar-default navbar-custom navbar-fixed-top">
            <div class="container top_menu">

                <!-- Grupowanie "marki" i przycisku rozwijania mobilnego menu -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>Menu<br>
                        <span><i class="fa fa-bars fa-2x"></i></span>
                    </button>

                </div>

                <!-- Grupowanie elementów menu w celu lepszego wyświetlania na urządzeniach moblinych -->
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav text-center">
                        <li><a href="{{ action('ContractorsController@create') }}"><i class="fa fa-handshake-o fa-2x"></i>Kontrahent</a></li>
                        <li><a href="{{ action('WarehouseQuantity@index') }}"><i class="fa fa-list fa-2x"></i>Kartoteka</a></li>
                        <li><a href="{{ action('Pz_documentsController@create') }}"><i class="fa fa-download fa-2x"></i>Przyjęcie</a></li>
                        <li><a href="{{ action('Wz_documentsController@create') }}"><i class="fa fa-sign-out fa-2x"></i>Wydanie</a></li>
                        <li><a href="{{ action('Zw_documentsController@create') }}"><i class="fa fa-sign-in fa-2x"></i>Zwrot</a></li>
                        <li><a href="{{ action('Lt_documentsController@create') }}"><i class="fa fa-trash fa-2x"></i>Likwidacja</a></li>
                        <li><a href="{{ action('BookingsController@create') }}"><i class="fa fa-thumb-tack fa-2x"></i>Rezerwacja</a></li>
                        <li><a href="{{ action('Return_transportsController@create') }}"><i class="fa fa-truck fa-2x"></i>Transport</a></li>

                       @if( Auth::user()->function == 'Administrator' )
                            <li><a href="{{action('UsersController@index')}}"><i class="fa fa-users fa-2x" aria-hidden="true"></i>Użytkownicy</a></li>
                       @endif
                        


                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right text-center">
                        <li>
                        <a href="{{ url('/home') }}"><i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>Witaj {{ Auth::user()->name }}</a>
                        </li>
                        <li>
                            <a href="{{ url('/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-window-close fa-2x" aria-hidden="true"></i>Wyloguj
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

<!-- Zawartość -->
        <article class="container master_content marg_b100">
            <div class="site-content">

                @yield('content')  <!-- dynamiczne dołczanie pliku -->
            </div>    
        </article>

<!-- Footer -->
        <footer class="pos_footer col-xs-12">
            <div class="container">
                <div class="row text-center">
                    <p class="log_footer">Warehouse Records 2017 <sup>&#174;</sup></p>    
                </div>
            </div>
        </footer>
    
        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.priceformat.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/price.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/tooltip.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/print.js') }}"></script>
        @yield('js')

        <!--Ikona w wyszukiwarce z font awesome -->
        <script>
            $('#iconified').on('keyup', function() {
                var input = $(this);
                if(input.val().length === 0) {
                    input.addClass('search');
                } else {
                    input.removeClass('search');
                }
            });    
        </script>
    </body>
</html>
