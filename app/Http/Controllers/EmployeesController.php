<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Employee;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateEmployeeRequest;
use Session;

class EmployeesController extends Controller
{
//Pobieranie listy użytkwoników
    public function index()
    {
        $search_pesel = Request::get('search_pesel');
        $search_name_empl = Request::get('search_name_empl');
        $search_surname_empl = Request::get('search_surname_empl');
        $search_email = Request::get('search_email');
        $search_telephone = Request::get('search_telephone');
        $search_function = Request::get('search_function');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_pesel != ''){
            $counter = Employee::where([['disable', '!=', TRUE],['pesel','like','%'.$search_pesel.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['pesel','like','%'.$search_pesel.'%']])->latest()->paginate($counter);}

        elseif($search_email != ''){
            $counter = Employee::where([['disable', '!=', TRUE],['email','like','%'.$search_email.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['email','like','%'.$search_email.'%']])->latest()->paginate($counter);}

        elseif($search_telephone != ''){
            $counter = Employee::where([['disable', '!=', TRUE],['telephone','like','%'.$search_telephone.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['telephone','like','%'.$search_telephone.'%']])->latest()->paginate($counter);}

        elseif($search_function != ''){
            $counter = Employee::where([['disable', '!=', TRUE],['function','like','%'.$search_function.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['function','like','%'.$search_function.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Employee::where([['disable', '!=', TRUE],['name_empl','like','%'.$search_name_empl.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['name_empl','like','%'.$search_name_empl.'%']])->latest()->paginate($counter);}
        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Employee::where([['disable', '!=', TRUE],['surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['surname_empl','like','%'.$search_surname_empl.'%']])->latest()->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Employee::where([['disable', '!=', TRUE],['name_empl','like','%'.$search_name_empl.'%'],['surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $employees = Employee::where([['disable', '!=', TRUE],['name_empl','like','%'.$search_name_empl.'%'],['surname_empl','like','%'.$search_surname_empl.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $employees = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('users.name')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $employees = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('users.surname')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $employees = Employee::where('employees.disable', '!=', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('users.surname')->paginate($counter);}

        else{
            $counter = Employee::where('disable', '!=', TRUE)->count();
            $employees = Employee::where('disable', '!=', TRUE)->latest()->paginate(30);}
        
    // Zwrócenie wyniku  
        return view('employees.index')->with('employees', $employees)->with('counter', $counter);
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$employee = Employee::findOrFail($id);
    	return view('employees.show')->with('employee', $employee);
    }

//Tworzenie nowego elemetu
    public function create()
    {
        return view('employees.create');
    }

//Zapisanie dodanego elementu
    public function store(CreateEmployeeRequest $request)
    {
        $this->validate($request, [
            'user_id'           => 'numeric',
            'pesel'             => 'required|max:11|regex:/^([0-9]{11})$/',
            'name_empl'         => 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]{2,})$/',
            'surname_empl'      => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'function'          => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'email'             => 'max:50|email',
            'telephone'         => 'max:50|regex:/^([0-9+\(]{1})([0-9]{1})([0-9\(\) x]{7,})$/',
            'disable'           => 'boolean',
         ]);

        Employee::create($request->all());

        //Informacje z sesji
        Session::flash('mes_employee_add', 'Pracownik został poprawnie dodany');

        //przekierowanie po udanej operacji
        return redirect('employees');
    }

// Edycja elementu
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit')->with('employee', $employee);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateEmployeeRequest $request)
    {
        $employee = Employee::findOrFail($id);

        $this->validate($request, [
            'user_id'           => 'numeric',
            'pesel'             => 'required|max:11|regex:/^([0-9]{11})$/',
            'name_empl'         => 'required|max:50|min:2|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ ]{2,})$/',
            'surname_empl'      => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'function'          => 'required|max:50|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\-_\. ]{2,})$/',
            'email'             => 'max:50|email',
            'telephone'         => 'max:50|regex:/^([0-9+\(]{1})([0-9]{1})([0-9\(\) x]{7,})$/',
            'disable'           => 'boolean',
         ]);

        $employee -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_employee_update', 'Zmiany został poprawie zapisane'); 

        //przekierowanie po udanej operacji
        return view('employees.show')->with('employee', $employee);
    }
}