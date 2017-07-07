<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Role;
use App\Location;
use App\Http\Requests\CreateUserRequest;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Support\JsonableInterface;

class UsersController extends Controller
{
//Pobieranie listy użytkwoników
    public function index()
    {
        $search_user_name  = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');
        $search_email = Request::get('search_email');
        $search_function = Request::get('search_function');
        $search_telephone = Request::get('search_telephone');

        if($search_email != ''){
            $counter = User::where('disable', null)->where('email','like','%'.$search_email.'%')->count();            
            $users = User::where('disable', null)->where('email','like','%'.$search_email.'%')->orderBy('name')->paginate($counter);}

        elseif($search_function != ''){
            $counter = User::where('disable', null)->where('function','like','%'.$search_function.'%')->count();            
            $users = User::where('disable', null)->where('function','like','%'.$search_function.'%')->orderBy('name')->paginate($counter);}
        
        elseif($search_telephone != ''){
            $counter = User::where('disable', null)->where('telephone','like','%'.$search_telephone.'%')->count();            
            $users = User::where('disable', null)->where('telephone','like','%'.$search_telephone.'%')->orderBy('name')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = User::where([['disable', null],['name','like','%'.$search_user_name.'%']])->count();
            $users = User::where([['disable', null],['name','like','%'.$search_user_name.'%']])->latest()->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = User::where([['disable', null],['surname','like','%'.$search_user_surname.'%']])->count();
            $users = User::where([['disable', null],['surname','like','%'.$search_user_surname.'%']])->latest()->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = User::where([['disable', null],['name','like','%'.$search_user_name.'%'],['surname','like','%'.$search_user_surname.'%']])->count();
            $users = User::where([['disable', null],['name','like','%'.$search_user_name.'%'],['surname','like','%'.$search_user_surname.'%']])->latest()->paginate($counter);}

        else{
            $counter = User::where('disable', null)->count();            
            $users = User::where('disable', null)->orderBy('name')->paginate(30);}
        
    // Zwrócenie wyniku  
        return view('users.index')->with('users', $users)->with('counter', $counter);
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show')->with('user', $user);
    }

//Dodanie nowego użytkownika
	public function create()
    {
        return view('users.create');
    }

//Zapisanie dodanego elementu
    public function store(CreateUserRequest $request)
    {
        // Walidacja
        $this->validate($request, [
            'name'              => 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]{2,})$/',
            'surname'           => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'email'             => 'required|email|max:50|unique:users,email',
            'function'          => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'telephone'         => 'max:50|regex:/^([0-9+\(]{1})([0-9]{1})([0-9\(\) x]{7,})$/',
            'password'          => 'required|min:8|max:20',
            ]);


        User::create([
            'remember_token'    => Input::get('remember_token'),
            'name'              => Input::get('name'),
            'surname'           => Input::get('surname'),
            'email'             => Input::get('email'),
            'function'          => Input::get('function'),
            'telephone'         => Input::get('telephone'),
            'password'          => Hash::make(Input::get('password')),
            ]);

        //Informacje z sesji
        Session::flash('mes_user_add', 'Dodano nowego użytkownika. Następnym krokiem jest nadanie mu uprawnień poprzez edycję');
        return redirect('users');
    }

// Edycja elementu
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit')->with('user', $user);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateUserRequest $request)
    {
        $user = User::findOrFail($id);

        // Walidacja
        $this->validate($request, [
            'name'              => 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]{2,})$/',
            'surname'           => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'email'             => 'required|email|max:50|unique:users,email',
            'email'             =>  Rule::unique('users')->ignore($user->id),
            'function'          => 'required|max:50',
            'telephone'         => 'max:50|min:7|regex:/^([0-9+\(]{1})([0-9]{1})([0-9\(\) x]{7,})$/',
            ]);


        // Aktualizowanie ról przydzielonch użytkownikom
        $user ->roles()->detach();
        if ($request['Administrator']) {
            $user->roles()->attach(Role::where('role_name', 'Administrator')->first());
        }
        if ($request['Magazynier']) {
            $user->roles()->attach(Role::where('role_name', 'Magazynier')->first());
        }
        if ($request['Kierownik']) {
            $user->roles()->attach(Role::where('role_name', 'Kierownik')->first());
        }
        if ($request['Księgowy']) {
            $user->roles()->attach(Role::where('role_name', 'Księgowy')->first());
        }

        $user -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_user_update', 'Zmiany został poprawie zapisane'); 

        //przekierowanie po udanej operacji
        return view('users.show')->with('user', $user);
    }
}
