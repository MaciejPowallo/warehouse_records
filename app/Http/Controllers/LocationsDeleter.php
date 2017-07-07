<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateLocationRequest;
use Session;

class LocationsDeleter extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_name = Request::get('search_name');
        $search_country = Request::get('search_country');
        $search_city = Request::get('search_city');
        $search_street = Request::get('search_street');
        $search_street_number = Request::get('search_street_number');
        $search_postcode = Request::get('search_postcode');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_name != ''){
            $counter = Location::where([['disable', TRUE],['location_name','like','%'.$search_name.'%']])->count();
            $locations = Location::where([['disable', TRUE],['location_name','like','%'.$search_name.'%']])->latest()->paginate($counter);}

        elseif($search_country != ''){
            $counter = Location::where([['disable', TRUE],['country','like','%'.$search_country.'%']])->count();
            $locations = Location::where([['disable', TRUE],['country','like','%'.$search_country.'%']])->latest()->paginate($counter);}

        elseif($search_city != ''){
            $counter = Location::where([['disable', TRUE],['city','like','%'.$search_city.'%']])->count();            
            $locations = Location::where([['disable', TRUE],['city','like','%'.$search_city.'%']])->latest()->paginate($counter);}

        elseif($search_street != ''){
            $counter = Location::where([['disable', TRUE],['street','like','%'.$search_street.'%']])->count();            
            $locations = Location::where([['disable', TRUE],['street','like','%'.$search_street.'%']])->latest()->paginate($counter);}

        elseif($search_street_number != ''){
            $counter = Location::where([['disable', TRUE],['street_number','like','%'.$search_street_number.'%']])->count();            
            $locations = Location::where([['disable', TRUE],['street_number','like','%'.$search_street_number.'%']])->latest()->paginate($counter);}

        elseif($search_postcode != ''){
            $counter = Location::where([['disable', TRUE],['postcode','like','%'.$search_postcode.'%']])->count();            
            $locations = Location::where([['disable', TRUE],['postcode','like','%'.$search_postcode.'%']])->latest()->paginate($counter);}

	//Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();                 
           $locations = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('users.name')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();                 
           $locations = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('users.surname')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();                 
            $locations = Location::where('locations.disable', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('users.surname')->paginate($counter);}

	// Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Location::where('disable', TRUE)->count();      
            $locations = Location::where('disable', TRUE)->latest()->paginate(30);
        }

    // Zwrócenie wyniku
        return view('locations.delete.index')->with('locations', $locations)->with('counter', $counter);  
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$location =	Location::findOrFail($id);
    	return view('locations.delete.show')->with('location', $location);
    }

// Edycja elementu
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.delete.edit')->with('location', $location);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateLocationRequest $request)
    {
        $location = Location::findOrFail($id);

        $this->validate($request, [
            'disable' => 'boolean',
         ]);

        $location -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_location_delete', 'Lokalizacja została zamknięta!'); 

        //przekierowanie po udanej operacji
       return redirect('locations');
    }
}
