@extends('master')
    @section('css')

        <link href="{{ URL::asset('css/slide_navigation.css') }}" rel="stylesheet" type="text/css">
        <link href='http://fonts.googleapis.com/css?family=Akronim&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Almendra&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

    @endsection

@section('content')

@include('panel.documents.date')
    <div class="row col-sm-3 col-sm-offset-9 col-xs-12 pad_b50">
        <div class="dropdown">
            <button class="btn btn-white dropdown-toggle" type="button" data-toggle="dropdown">
                Zalogowano jako {{ Auth::user()->name }} {{ Auth::user()->surname }}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Ustawienia</a></li>
                <li><a href="#">Zmień awatar</a></li>
            </ul>
        </div>
    </div>
<div class="content-position container">
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading pad_b50">
                    <div class="col-xs-6 top_date">
                        <div class="text-left">    
                            <?php echo '<div>'.dzien_tyg(date("w")).', '.date("d").' '.miesiac_pl(date("n")).' '.date("Y").'</div>'; ?>
                        </div>
                    </div> 
                    <div class="col-xs-6 top_date">
                        <body onload="startTime()">
                            <div class="text-right" id="txt"></div>
                        </body>
                    </div>    
                </div>
                    
                <div class="panel-body">
                    
                    <div id="kalendarz">
                        <div class="col-xs-6 col-sm-5 col-sm-offset-1 text-right top_date">
                        <a href="#"><small> << </small></a>
                            <?php echo miesiace_pl(date("n")); ?>
                        </div>
                        <div class="col-xs-6 col-sm-5 col-sm-offset-right-1 text-left top_date">
                            <?php echo date("Y"); ?>
                        <a href="#"><small> >> </small></a>
                        </div>

    
                        <div class="col-xs-12 col-sm-11 col-sm-offset-1 text-center name">

                            <div class="col14">Pn</div>
                            <div class="col14">Wt</div>
                            <div class="col14">Śr</div>
                            <div class="col14">Cz</div>
                            <div class="col14">Pt</div>
                            <div class="col14">Sb</div>
                            <div class="col14 red_text">N</div>
                        </div>
                        <div class="col-xs-12 col-sm-11 col-sm-offset-1 text-left ">
                            <?php
                                for($i=1;$i<dzien_tyg_nr(date("n"),date("Y"));$i++)
                                 echo '<div class="no_vis col14"> </div> ';

                                for($i=1;$i<dni_mies(date("n"),date("Y"));$i++) 
                                {
                                    if ($i<10) $i = '0'.$i;
                                    if ($i == date("d")) echo '<div class="akt col14">'.$i.'</div> ';
                                    else echo '<div class="col14 day">'.$i.'</div> ';
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Menu boczne -->
<span onclick="openNav()"><div class="open_sidenav"><i class="fa fa-angle-double-right fa-3x" aria-hidden="true"></i></div></span>

<div id="mySidenav" class="sidenav">
    <div><a href="javascript:void(0)" class="closebtn text-right" onclick="closeNav()">&times;</a></div>
    <div class="dropdown">
        <div class="caret_right caret_down">Kontrahenci
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><a href="{{ action('ContractorsController@index') }}">Wykaz kontrahentów</a></div>
            <div class="child"><a href="{{ action('ContractorsController@create') }}">Dodaj kontrahenta</a></div>
            <div class="child"><a href="{{ action('ContractorsDeleter@index') }}">Nieaktywni kontrahenci</a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Pracownicy
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><a href="{{ action('EmployeesController@index') }}">Wykaz pracowników</a></div>
            <div class="child"><a href="{{ action('EmployeesController@create') }}">Dodaj procownika</a></div>
            <div class="child"><a href="{{ action('EmployeesDeleter@index') }}">Wykaz zwolnionych</a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Lokalizacje
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><a href="{{ action('LocationsController@index') }}">Wykaz lokalizacji</a></div>
            <div class="child"><a href="{{ action('LocationsController@create') }}">Dodaj lokalizację</a></div>
            <div class="child"><a href="{{ action('LocationsDeleter@index') }}">Zamknięte lokalizacje</a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Towary
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><strong>Wyświetl</strong></div>
            <div class="child"><a href="{{ action('ProductsController@index') }}">Wykaz produktów</a></div>
            <div class="child"><a href="{{ action('GradesController@index') }}">Grupy produktów</a></div>  
            <div class="child"><a href="{{ action('TypesController@index') }}">Rodzaje produktów</a></div> 
            <div class="child"><strong>Dodaj</strong></div>
            <div class="child"><a href="{{ action('ProductsController@create') }}">Dodaj produkt</a></div>
            <div class="child"><a href="{{ action('GradesController@create') }}">Dodaj grupę</a></div>                  
            <div class="child"><a href="{{ action('TypesController@create') }}">Dodaj rodzaj</a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Stany
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><a href="{{ action('TotalQuantity@index') }}">Stan ogólny</a></div>
            <div class="child"><a href="{{ action('WarehouseQuantity@index') }}">Stan magazynu</a></div>
            <div class="child"><a href="#">Stan zliwidowanych</a></div>
            <div class="child"><a href="{{ action('LocationQuantity@index') }}">Stany lokalizacji</a></div>
            <div class="child"><a href="#">Stany pracownika</a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Dokumenty
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><strong>Wyświetl</strong></div>
            <div class="child"><a href="{{ action('Wz_documentsApprover@index') }}">Wykaz wydań (WZ) </a></div>
            <div class="child"><a href="{{ action('Pz_documentsApprover@index') }}">Wykaz przyjęć (PZ) </a></div>
            <div class="child"><a href="{{ action('Zw_documentsApprover@index') }}">Wykaz zwrotów (ZW) </a></div>
            <div class="child"><a href="{{ action('Lt_documentsApprover@index') }}">Wykaz likwidacji (LT) </a></div>
            <div class="child"><strong>Dodaj</strong></div>
            <div class="child"><a href="{{ action('Wz_documentsController@create') }}">Dodaj wydanie (+ WZ) </a></div>
            <div class="child"><a href="{{ action('Pz_documentsController@create') }}">Dodaj przyjęcie (+ PZ) </a></div>
            <div class="child"><a href="{{ action('Zw_documentsController@create') }}">Dodaj zwrot (+ ZW) </a></div>
            <div class="child"><a href="{{ action('Lt_documentsController@create') }}">Dodaj likwidację (+ LT) </a></div>
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Rezerwacje
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><strong>Wyświetl</strong></div>
            <div class="child"><a href="{{ action('BookingsMediator@index') }}">Zatwierdzone</a></div>
            <div class="child"><a href="{{ action('BookingsApprover@index') }}">W realizacji</a></div>
            <div class="child"><a href="{{ action('BookingsController@index') }}">Niezatwierdzone</a></div>
            <div class="child"><strong>Dodaj</strong></div>
            <div class="child"><a href="{{ action('BookingsController@create') }}">Nowa rezerwacja</a></div>   
    </div> 
    <div class="dropdown">
        <div class="caret_right caret_down">Transporty
            <i class="fa fa-caret-right" aria-hidden="true"></i>
            <i class="fa fa-caret-down" aria-hidden="true"></i>
        </div>
            <div class="child"><strong>Wyświetl</strong></div>
            <div class="child"><a href="{{ action('Return_transportsMediator@index') }}">Zatwierdzone</a></div>
            <div class="child"><a href="{{ action('Return_transportsApprover@index') }}">W realizacji</a></div>
            <div class="child"><a href="{{ action('Return_transportsController@index') }}">Niezatwierdzone</a></div>
            <div class="child"><strong>Dodaj</strong></div>
            <div class="child"><a href="{{ action('Return_transportsController@create') }}">Nowy transport</a></div>    
    </div> 
</div>

@endsection

@section('js')
        <script type="text/javascript" src="{{ URL::asset('js/slide_navigation.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/clock.js') }}"></script>
@endsection