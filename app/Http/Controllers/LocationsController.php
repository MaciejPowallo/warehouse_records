<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateLocationRequest;
use Session;

class LocationsController extends Controller
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
            $counter = Location::where([['disable', '!=', TRUE],['location_name','like','%'.$search_name.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['location_name','like','%'.$search_name.'%']])->latest()->paginate($counter);}

        elseif($search_country != ''){
            $counter = Location::where([['disable', '!=', TRUE],['country','like','%'.$search_country.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['country','like','%'.$search_country.'%']])->latest()->paginate($counter);}

        elseif($search_city != ''){
            $counter = Location::where([['disable', '!=', TRUE],['city','like','%'.$search_city.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['city','like','%'.$search_city.'%']])->latest()->paginate($counter);}

        elseif($search_street != ''){
            $counter = Location::where([['disable', '!=', TRUE],['street','like','%'.$search_street.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['street','like','%'.$search_street.'%']])->latest()->paginate($counter);}

        elseif($search_street_number != ''){
            $counter = Location::where([['disable', '!=', TRUE],['street_number','like','%'.$search_street_number.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['street_number','like','%'.$search_street_number.'%']])->latest()->paginate($counter);}

        elseif($search_postcode != ''){
            $counter = Location::where([['disable', '!=', TRUE],['postcode','like','%'.$search_postcode.'%']])->count();
            $locations = Location::where([['disable', '!=', TRUE],['postcode','like','%'.$search_postcode.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $locations = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('locations.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $locations = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('locations.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $locations = Location::where('locations.disable', '!=', TRUE)->join('users','users.id','=','locations.user_id')->select('locations.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('locations.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Location::where('disable', '!=', TRUE)->count();
            $locations = Location::where('disable', '!=', TRUE)->latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('locations.index')->with('locations', $locations)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$location =	Location::findOrFail($id);
    	return view('locations.show')->with('location', $location);
    }

//Tworzenie nowego elemetu
    public function create()
    {
        return view('locations.create');
    }

//Zapisanie dodanego elementu
    public function store(CreateLocationRequest $request)
    {
        $this->validate($request, [
            'location_name'     => 'required|max:50|unique:locations,location_name|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{1})([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\(\)._&\/ ]{2,})$/',
            'user_id'           => 'numeric',
            'country'           => 'max:50|required|regex:/^([a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{1})([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._]{1,})$/',
            'city'              => 'max:50|min:3|required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._]{3,})$/',
            'street'            => 'max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._&]{1,})$/',
            'street_number'     => 'max:10|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._&\/]{1,})$/',
            'postcode'          => 'max:10|regex:/^([\d]{1,})([- ]{0,1})([\d]{2,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
            'disable'           => 'boolean',
         ]);

        Location::create($request->all());

        //Informacje z sesji
        Session::flash('mes_location_add', 'Lokalizacja została poprawnie dodana');

        //przekierowanie po udanej operacji
        return redirect('locations');
    }

// Edycja elementu
    public function edit($id)
    {
        $location = Location::findOrFail($id);
        return view('locations.edit')->with('location', $location);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateLocationRequest $request)
    {
        $location = Location::findOrFail($id);

        $this->validate($request, [
            'location_name'     => ['required','max:50','regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{1})([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-\(\)._&\/ ]{2,})$/', Rule::unique('locations')->ignore($location->id)],
            'user_id'           => 'numeric',
            'country'           => 'max:50|required|regex:/^([a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ]{1})([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._]{1,})$/',
            'city'              => 'max:50|min:3|required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._]{3,})$/',
            'street'            => 'max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._&\/]{1,})$/',
            'street_number'     => 'max:10|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ \-\(\)._&\/]{1,})$/',
            'postcode'          => 'max:10|regex:/^([\d]{1,})([- ]{0,1})([\d]{2,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
            'disable'           => 'boolean',

         ]);

        $location -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_location_update', 'Zmiany został poprawie zapisane'); 

        //przekierowanie po udanej operacji
        return view('locations.show')->with('location', $location);
    }
}
