<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use App\Employee;
use App\Product;
use App\Zw_document;
use App\Product_zw_documents;
use App\Product_wz_documents;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateZw_documentRequest;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class Zw_documentsController extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_zw_date = Request::get('search_zw_date');
        $search_location_name = Request::get('search_location_name');
        $search_name_empl = Request::get('search_name_empl');
        $search_surname_empl = Request::get('search_surname_empl');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');
 
        if($search_doc_numb != ''){
            $counter = Zw_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $zw_documents = Zw_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_zw_date != ''){
            $counter = Zw_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_zw_date.'%']])->count();
            $zw_documents = Zw_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_zw_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('locations','locations.id','=','zw_documents.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('locations','locations.id','=','zw_documents.locations_id')->select('zw_documents.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('zw_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $zw_documents = Zw_document::where('zw_documents.approved', '!=', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('zw_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Zw_document::where('approved', '!=', TRUE)->count();
            $zw_documents = Zw_document::where('approved', '!=', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.zw.index')->with('zw_documents', $zw_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $zw_document =  Zw_document::findOrFail($id);
        $approved = $zw_document->approved;
        if($approved != 1){
            return view('documents.zw.show')->with('zw_document', $zw_document);
        }
        else{
            return redirect('documents/approved/zw/'.$id);
        }
    }

//Tworzenie nowego elemetu
    public function create()
    {
        //Wybór pracownika
        $employee = Employee::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",surname_empl," ",name_empl, " PESEL: ", pesel) AS surname_empl'),'id')->get()->sortBy('surname_empl')->pluck('surname_empl','id');

        //Wybór pracownika
        $location = Location::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",location_name," -> ",postcode," ", city) AS location_name'),'id')->get()->sortBy('location_name')->pluck('location_name','id');

        return view('documents.zw.create')->with(compact('employee', 'location'));
    }

//Zapisanie dodanego elementu
    public function store(CreateZw_documentRequest $request)
    {
        $this->validate($request, [
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
            'disable'           => 'boolean',
         ]);

    //Zapisanie wszystkiego z żądania
        $zw_documents = new Zw_document($request->all());

    // Dołączenie pracownika
        $employees = $request->input('employee');
        $zw_documents->employee()->associate($employees);

    // Dołączenie lokalizacji
        $locations = $request->input('location');
        $zw_documents->location()->associate($locations);

    //Zapisanie wszystkiego
        $zw_documents->save();

    // Pobranie potrzebnych zmiennych
        $id =	Zw_document::orderBy('id', 'desc')->first()->id;
        $employee_id =  Zw_document::orderBy('id', 'desc')->first()->employee_id; 
        $location_id =	Zw_document::orderBy('id', 'desc')->first()->locations_id; 

    // Nadanie numeru
        Zw_document::where('id', $id)->update(['doc_numb' => 'ZW/'.$id.'/'.$employee_id.'/'.$location_id.'/'.date('m/Y')]);    

    //przekierowanie po udanej operacji
    	return redirect('documents/zw/'.$id);
    } 

// Edycja elementu
    public function edit($id)
    {
        $zw_document = Zw_document::findOrFail($id);



        //$counter = Zw_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();


        //scalenie kilku kolumn w jedną i wyświetlenie jej w polu select
		$product_name =	Product::where([['quantity', '!=', NULL],['disable', '!=', TRUE]])->select(
            DB::raw('CONCAT_WS("",catalog_nr," || ",product_name," || Ilość: ",quantity, " || ", unit," po ",price," PLN") AS product_name'),'id')->pluck('product_name', 'id');

        return view('documents.zw.edit')->with(compact('zw_document', 'product_name'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateZw_documentRequest $request)
    {
        $zw_document = Zw_document::findOrFail($id);

        //dodanie nowego produktu do pivota
        $zw_document -> products() -> attach($request->input('product_name'));

        //znajdujemy ostatni produkt w pivocie z danego dokuemtu Zw i dopisujemy do niego ilość
        $id =	Product_zw_documents::where('zw_id', $id)->orderBy('id', 'desc')->first()->id;
 		Product_zw_documents::where('id', $id)->update(['quantity' => ($request->input('quantity'))]);

        //przekierowanie po udanej operacji
        return view('documents.zw.show')->with('zw_document', $zw_document);
    }

//Usunięcie niezatwierdzonego 
    public function destroy($id)
    {
        $zw_document = Zw_document::findOrFail($id);
        $zw_document->delete();
        Session::flash('mes_zw_delete','Dokument został poprawnie usunięty');
        return redirect('documents/zw');
    } 
}