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

class Return_transportsController extends Controller
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
            $counter = Return_transport::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $transports = Return_transport::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_driver != ''){
            $counter = Return_transport::where([['approved', '!=', TRUE],['driver','like','%'.$search_driver.'%']])->count();
            $transports = Return_transport::where([['approved', '!=', TRUE],['driver','like','%'.$search_driver.'%']])->latest()->paginate($counter);}

        elseif($search_vehicle != ''){
            $counter = Return_transport::where([['approved', '!=', TRUE],['vehicle','like','%'.$search_vehicle.'%']])->count();
            $transports = Return_transport::where([['approved', '!=', TRUE],['vehicle','like','%'.$search_vehicle.'%']])->latest()->paginate($counter);}

        elseif($search_transport_date != ''){
            $counter = Return_transport::where([['approved', '!=', TRUE],['transport_date','like','%'.$search_transport_date.'%']])->count();
            $transports = Return_transport::where([['approved', '!=', TRUE],['transport_date','like','%'.$search_transport_date.'%']])->latest()->paginate($counter);}

        elseif($search_created_date != ''){
            $counter = Return_transport::where([['approved', '!=', TRUE],['created_at','like','%'.$search_created_date.'%']])->count();
            $transports = Return_transport::where([['approved', '!=', TRUE],['created_at','like','%'.$search_created_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('locations','locations.id','=','return_transports.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('locations','locations.id','=','return_transports.locations_id')->select('return_transports.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('return_transports.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('employees','employees.id','=','return_transports.employee_id')->select('return_transports.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('return_transports.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('return_transports.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $transports = Return_transport::where('return_transports.approved', '!=', TRUE)->join('users','users.id','=','return_transports.user_id')->select('return_transports.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('return_transports.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Return_transport::where('approved', '!=', TRUE)->count();
            $transports = Return_transport::where('approved', '!=', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('transports.index')->with('transports', $transports)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $transport =  Return_transport::findOrFail($id);
        $approved = $transport->approved;
        $accepted = $transport->accepted;

        if($approved != 1){
            return view('transports.show')->with('transport', $transport);
        }
        else{
        	if($accepted === NULL) {
	        	return redirect('transports/approved/'.$id);
        	}
	        else{
	        	return redirect('transports/mediate/'.$id);
	        }
    	}
    }


//Tworzenie nowego elemetu
    public function create()
    {

        //Wybór pracownika
        $employee = Employee::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",surname_empl," ",name_empl, " PESEL: ", pesel) AS surname_empl'),'id')->get()->sortBy('surname_empl')->pluck('surname_empl','id');

        //Wybór lokalizacji
        $location = Location::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",location_name," -> ",postcode," ", city) AS location_name'),'id')->get()->sortBy('location_name')->pluck('location_name','id');

        return view('transports.create')->with(compact('employee', 'location'));
    }


//Zapisanie dodanego elementu
    public function store(CreateReturn_transpostRequest $request)
    {
        $this->validate($request, [
            'disable'           => 'boolean',
         ]);

    //Zapisanie wszystkiego z żądania
        $transport = new Return_transport($request->all());

    // Dołączenie lokalizacji
        $location = $request->input('location');
        $transport->location()->associate($location);

    // Dołączenie pracownika
        $employee = $request->input('employee');
        $transport->employee()->associate($employee);

    //Zapisanie wszystkiego
        $transport->save();

    // Pobranie potrzebnych zmiennych
        $id =	Return_transport::orderBy('id', 'desc')->first()->id;
        $location_id =	Return_transport::orderBy('id', 'desc')->first()->locations_id; 

    // Nadanie numeru
        Return_transport::where('id', $id)->update(['doc_numb' => $id.'/'.$location_id.'/'.date('m/Y')]);    

    //przekierowanie po udanej operacji
    	return redirect('transports/'.$id);
    } 

// Edycja elementu
    public function edit($id)
    {
        $transport = Return_transport::findOrFail($id);

        //scalenie kilku kolumn w jedną i wyświetlenie jej w polu select
        
		$product_name =	Product::where([['disable', '!=', TRUE]])->select(
            DB::raw('CONCAT_WS("", catalog_nr," --> ",product_name," [ Jednostka: ", unit," ]") AS product_name'),'id')->pluck('product_name', 'id');

        return view('transports.edit')->with(compact('transport', 'product_name'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateReturn_transpostRequest $request)
    {
        //wyszukanie id dokumentu
        $transport = Return_transport::findOrFail($id);

        //dodanie nowego produktu do pivota
        $transport -> products() -> attach($request->input('product_name'));
        
        //znajdujemy ostatni produkt w pivocie z danej rezerwacji i dopisujemy do niego ilość
        $id = Product_return_transports::where('transport_id', $id)->orderBy('id', 'desc')->first()->id;
     	Product_return_transports::where('id', $id)->update(['quantity' => ($request->input('quantity'))]);

        //przekierowanie po udanej operacji
        return view('transports.show')->with('transport', $transport);

    }

//Usunięcie niezatwierdzonego 
    public function destroy($id)
    {
        $transport = Return_transport::findOrFail($id);
        $transport->delete();
        Session::flash('mes_transport_delete','Dokument został poprawnie usunięty');
        return redirect('transports');
    } 
}




