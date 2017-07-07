<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index');
});


/* 
*	--------------------------------------------------------------------------
*	Kontrolery dostępne dla wszystkich
*	--------------------------------------------------------------------------
*/
//Błąd dostępu
Route::get('/error', 'PagesController@error');

// Logowanie
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout');

/* 
*	--------------------------------------------------------------------------
*	Kontrolery dostępne dla administratora
*	--------------------------------------------------------------------------
*/
Route::group([
	'middleware' => ['web','roles'],
	'roles' => 'Administrator'
], 
	function ()
	{
		//Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
       	//Route::post('/register', 'Auth\RegisterController@register');
        
		Route::resource('users', 'UsersController', ['except' => ['destroy']]);
		Route::resource('changepassword', 'ChangeUserPassword', ['only' => ['update', 'edit']]);
		Route::resource('users/delete', 'UsersDeleter', ['except' => ['destroy']]);
	});

/* 
*	--------------------------------------------------------------------------
*	Kontrolery dostępne dla magazyniera
*	--------------------------------------------------------------------------
*/
Route::group([
	'middleware' => ['web','roles'],
	'roles' => 'Magazynier'
], 
	function ()
	{
		Route::resource('products/delete', 'ProductsDeleter', ['except' => ['destroy']]);
		Route::resource('products', 'ProductsController', ['except' => ['destroy']]);
		Route::resource('types', 'TypesController', ['except' => ['destroy']]);
		Route::resource('grades', 'GradesController', ['except' => ['destroy']]);
		Route::resource('locations/delete', 'LocationsDeleter', ['except' => ['destroy']]);
		Route::resource('locations','LocationsController', ['except' => ['destroy']]);
		Route::resource('contractors/delete','ContractorsDeleter', ['except' => ['destroy']]);	
		Route::resource('contractors','ContractorsController', ['except' => ['destroy']]);	
		Route::resource('employees/delete','EmployeesDeleter', ['except' => ['destroy']]);			
		Route::resource('employees','EmployeesController', ['except' => ['destroy']]);

//dokumenty magazynowe
		Route::resource('documents/pz','Pz_documentsController');
		Route::resource('documents/wz','Wz_documentsController');
		Route::resource('documents/zw','Zw_documentsController');
		Route::resource('documents/lt','Lt_documentsController');
		Route::resource('documents/approved/pz','Pz_documentsApprover', ['except' => ['destroy']]);
		Route::resource('documents/approved/wz','Wz_documentsApprover', ['except' => ['destroy']]);
		Route::resource('documents/approved/zw','Zw_documentsApprover', ['except' => ['destroy']]);
		Route::resource('documents/approved/lt','Lt_documentsApprover', ['except' => ['destroy']]);

//Rezerwacje
		Route::resource('bookings/mediate','BookingsMediator', ['except' => ['destroy']]);

//Transporty zwrotne
		Route::resource('transports/mediate','Return_transportsMediator', ['except' => ['destroy']]);
	});

/* 
*	--------------------------------------------------------------------------
*	Kontrolery dostępne dla kierownika
*	--------------------------------------------------------------------------
*/
Route::group([
	'middleware' => ['web','roles'],
	'roles' => 'Kierownik'
], 
	function ()
	{
		Route::resource('products', 'ProductsController', ['only' => ['index', 'show']]);	
		Route::resource('locations', 'LocationsController', ['only' => ['index', 'show']]);
		Route::resource('contractors','ContractorsController', ['only' => ['index', 'show']]);
		Route::resource('employees','EmployeesController', ['only' => ['index', 'show']]);

//dokumenty magazynowe	
		Route::resource('documents/approved/pz','Pz_documentsApprover', ['only' => ['index', 'show']]);
		Route::resource('documents/approved/wz','Wz_documentsApprover', ['only' => ['index', 'show']]);
		Route::resource('documents/approved/zw','Zw_documentsApprover', ['only' => ['index', 'show']]);
		Route::resource('documents/approved/lt','Lt_documentsApprover', ['only' => ['index', 'show']]);	

//Rezerwacje
		Route::resource('bookings/approved','BookingsApprover', ['except' => ['destroy']]);
		Route::resource('bookings/mediate','BookingsMediator', ['only' => ['index', 'show']]);;
		Route::resource('bookings','BookingsController');

//Transporty zwrotne
		Route::resource('transports/approved','Return_transportsApprover', ['except' => ['destroy']]);
		Route::resource('transports/mediate','Return_transportsMediator', ['only' => ['index', 'show']]);
		Route::resource('transports','Return_transportsController');
		

	});

/* 
*	--------------------------------------------------------------------------
*	Kontrolery dostępne dla księgowego
*	--------------------------------------------------------------------------
*/
Route::group([
	'middleware' => ['web','roles'],
	'roles' => 'Księgowy'
], 
	function ()
	{
		Route::get('/warehouserecords/total', 'TotalQuantity@index');
		Route::get('/warehouserecords/warehouse', 'WarehouseQuantity@index');
		Route::get('/warehouserecords/liquidation', 'LiquidationQuantity@index');
		Route::get('/warehouserecords/employee', 'EmployeeQuantity@index');
		Route::get('/warehouserecords/location', 'LocationQuantity@index');
		Route::get('/home', 'HomeController@index');	
	});