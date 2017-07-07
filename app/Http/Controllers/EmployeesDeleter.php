<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Employee;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateEmployeeRequest;
use Session;

class EmployeesDeleter extends Controller
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
            $counter = Employee::where([['disable', TRUE],['pesel','like','%'.$search_pesel.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['pesel','like','%'.$search_pesel.'%']])->latest()->paginate($counter);}

        elseif($search_email != ''){
            $counter = Employee::where([['disable', TRUE],['email','like','%'.$search_email.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['email','like','%'.$search_email.'%']])->latest()->paginate($counter);}

        elseif($search_telephone != ''){
            $counter = Employee::where([['disable', TRUE],['telephone','like','%'.$search_telephone.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['telephone','like','%'.$search_telephone.'%']])->latest()->paginate($counter);}

        elseif($search_function != ''){
            $counter = Employee::where([['disable', TRUE],['function','like','%'.$search_function.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['function','like','%'.$search_function.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Employee::where([['disable', TRUE],['name_empl','like','%'.$search_name_empl.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['name_empl','like','%'.$search_name_empl.'%']])->latest()->paginate($counter);}
        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Employee::where([['disable', TRUE],['surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['surname_empl','like','%'.$search_surname_empl.'%']])->latest()->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Employee::where([['disable', TRUE],['name_empl','like','%'.$search_name_empl.'%'],['surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $employees = Employee::where([['disable', TRUE],['name_empl','like','%'.$search_name_empl.'%'],['surname_empl','like','%'.$search_surname_empl.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $employees = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('users.name')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $employees = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('users.surname')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $employees = Employee::where('employees.disable', TRUE)->join('users','users.id','=','employees.user_id')->select('employees.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('users.surname')->paginate($counter);}

        else{
            $counter = Employee::where('disable', TRUE)->count();
            $employees = Employee::where('disable', TRUE)->latest()->paginate(30);}
        
    // Zwrócenie wyniku  
        return view('employees.delete.index')->with('employees', $employees)->with('counter', $counter);
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$employee = Employee::findOrFail($id);
    	return view('employees.delete.show')->with('employee', $employee);
    }
    
// Edycja elementu
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.delete.edit')->with('employee', $employee);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateEmployeeRequest $request)
    {
        $employee = Employee::findOrFail($id);

       $this->validate($request, [
            'disable' => 'boolean',
         ]);

        $employee -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_employee_delete', 'Pracownik został zwolniony'); 

        //przekierowanie po udanej operacji
        return redirect('employees');
    }
}
