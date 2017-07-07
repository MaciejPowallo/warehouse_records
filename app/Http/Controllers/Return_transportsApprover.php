<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Employee;
use App\Location;
use App\Product;
use App\Return_transport;
use App\Product_return_transports;
use App\Http\Requests\CreateReturn_transpostRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;


class Return_transportsApprover extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_location_name = Request::get('search_location_name');
        $search_driver = Request::get('search_driver');
        $search_vehicle = Request::get('search_vehicle');
        $search_transport_date = Request::get('search_transport_date');
        $search_created_date = Request::get('search_created_date');
        $search_name_empl = Request::get('search_name_empl');
        $search_surname_empl = Request::get('search_surname_empl');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_doc_numb != ''){
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_driver != ''){
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL],['driver','like','%'.$search_driver.'%']])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL],['driver','like','%'.$search_driver.'%']])->latest()->paginate($counter);}

        elseif($search_vehicle != ''){
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL],['vehicle','like','%'.$search_vehicle.'%']])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL],['vehicle','like','%'.$search_vehicle.'%']])->latest()->paginate($counter);}

        elseif($search_transport_date != ''){
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL],['transport_date','like','%'.$search_transport_date.'%']])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL],['transport_date','like','%'.$search_transport_date.'%']])->latest()->paginate($counter);}

        elseif($search_created_date != ''){
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL],['created_at','like','%'.$search_created_date.'%']])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL],['created_at','like','%'.$search_created_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('locations','locations.id','=','return_transports.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('locations','locations.id','=','return_transports.locations_id')->select('return_transports.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('return_transports.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('return_transports.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $transports = Return_transport::where([['return_transports.approved', TRUE],['return_transports.accepted', NULL]])->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('return_transports.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Return_transport::where([['approved', TRUE],['accepted', NULL]])->count();
            $transports = Return_transport::where([['approved', TRUE],['accepted', NULL]])->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('transports.approved.index')->with('transports', $transports)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $transport =  Return_transport::findOrFail($id);
        $approved = $transport->approved;
        $accepted = $transport->accepted;

        if($approved != 1){
            return redirect('transports/'.$id);
        }
        else{
        	if($accepted === NULL) {
        		return view('transports.approved.show')->with('transport', $transport);
        	}
	        else{
				return redirect('transports/mediate/'.$id);
	        }
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $transport = Return_transport::findOrFail($id);

        return view('transports.approved.edit')->with('transport', $transport);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateReturn_transpostRequest $request)
    {
        $transport = Return_transport::findOrFail($id);

        $this->validate($request, [
            'approved' => 'boolean',
         ]);

        //aktualizacja wpisu 
        $transport -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('transports.approved.show')->with('transport', $transport);
    }

}
