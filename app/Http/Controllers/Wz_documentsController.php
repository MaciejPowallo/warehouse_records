<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use App\Employee;
use App\Product;
use App\Wz_document;
use App\Product_wz_documents;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateWz_documentRequest;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class Wz_documentsController extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_expend = Request::get('search_expend');
        $search_wz_date = Request::get('search_wz_date');
        $search_location_name = Request::get('search_location_name');
        $search_name_empl = Request::get('search_name_empl');
        $search_surname_empl = Request::get('search_surname_empl');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_doc_numb != ''){
            $counter = Wz_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $wz_documents = Wz_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_expend != ''){
            $counter = Wz_document::where([['approved', '!=', TRUE],['expend','like','%'.$search_expend.'%']])->count();
            $wz_documents = Wz_document::where([['approved', '!=', TRUE],['expend','like','%'.$search_expend.'%']])->latest()->paginate($counter);}

        elseif($search_wz_date != ''){
            $counter = Wz_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_wz_date.'%']])->count();
            $wz_documents = Wz_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_wz_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('locations','locations.id','=','wz_documents.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('locations','locations.id','=','wz_documents.locations_id')->select('wz_documents.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('wz_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $wz_documents = Wz_document::where('wz_documents.approved', '!=', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('wz_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Wz_document::where('approved', '!=', TRUE)->count();
            $wz_documents = Wz_document::where('approved', '!=', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.wz.index')->with('wz_documents', $wz_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $wz_document =  Wz_document::findOrFail($id);
        $approved = $wz_document->approved;
        if($approved != 1){
            return view('documents.wz.show')->with('wz_document', $wz_document);
        }
        else{
            return redirect('documents/approved/wz/'.$id);
        }
    }

//Tworzenie nowego elemetu
    public function create()
    {
        //Wybór pracownika
        $employee = Employee::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",surname_empl," ",name_empl, " PESEL: ", pesel) AS surname_empl'),'id')->get()->sortBy('surname_empl')->pluck('surname_empl','id');

        //Wybór pracownika
        $location = Location::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",location_name," -> ",postcode," ", city) AS location_name'),'id')->get()->sortBy('location_name')->pluck('location_name','id');

        return view('documents.wz.create')->with(compact('employee', 'location'));
    }

//Zapisanie dodanego elementu
    public function store(CreateWz_documentRequest $request)
    {
        $this->validate($request, [
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
            'disable'           => 'boolean',
         ]);

    //Zapisanie wszystkiego z żądania
        $wz_documents = new Wz_document($request->all());

    // Dołączenie pracownika
        $employees = $request->input('employee');
        $wz_documents->employee()->associate($employees);

    // Dołączenie lokalizacji
        $locations = $request->input('location');
        $wz_documents->location()->associate($locations);

    //Zapisanie wszystkiego
        $wz_documents->save();

    // Pobranie potrzebnych zmiennych
        $id =	Wz_document::orderBy('id', 'desc')->first()->id;
        $employee_id =  Wz_document::orderBy('id', 'desc')->first()->employee_id; 
        $location_id =	Wz_document::orderBy('id', 'desc')->first()->locations_id; 

    // Zapis wybranego typu dokumentu  
        Wz_document::where('id', $id)->update(['expend' => $request->input('expend')]);  

    // Pobranie typu dokumentu
        $type = Wz_document::orderBy('id', 'desc')->first()->expend;

    // Nadanie numeru
        if($type == 1){
     		Wz_document::where('id', $id)->update(['doc_numb' => 'RW/'.$id.'/'.$employee_id.'/'.$location_id.'/'.date('m/Y')]);  
        }
        else{
            Wz_document::where('id', $id)->update(['doc_numb' => 'WZ/'.$id.'/'.$employee_id.'/'.$location_id.'/'.date('m/Y')]);    
        }

    //przekierowanie po udanej operacji
    	return redirect('documents/wz/'.$id);
    } 

// Edycja elementu
    public function edit($id)
    {
        $wz_document = Wz_document::findOrFail($id);

        //scalenie kilku kolumn w jedną i wyświetlenie jej w polu select
		$product_name =	Product::where([['quantity', '>', 0],['disable', '!=', TRUE]])->select(
            DB::raw('CONCAT_WS("",catalog_nr," || ",product_name," || Ilość: ",quantity, " || ", unit," po ",price," PLN") AS product_name'),'id')->pluck('product_name', 'id');

        return view('documents.wz.edit')->with(compact('wz_document', 'product_name'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateWz_documentRequest $request)
    {
        //wyszukanie id dokumentu
        $wz_document = Wz_document::findOrFail($id);

        //dodanie nowego produktu do pivota
        $wz_document -> products() -> attach($request->input('product_name'));

        //pobieram dane z pivota oraz tabeli produkty
        $quantity = Product_wz_documents::where('wz_id', $id)->orderBy('id', 'desc')->first();
        $product = Product::where('id', $quantity->product_id)->first();
        
        if(($request->input('quantity')) <= $product->quantity)
        {
            //znajdujemy ostatni produkt w pivocie z danego dokuemtu Wz i dopisujemy do niego ilość
            $id =	Product_wz_documents::where('wz_id', $id)->orderBy('id', 'desc')->first()->id;
     		Product_wz_documents::where('id', $id)->update(['quantity' => ($request->input('quantity'))]);

            //przekierowanie po udanej operacji
            return view('documents.wz.show')->with('wz_document', $wz_document);
        }
        else
        {
            //skasuj ostatni wpis
            $wz_document -> products() -> detach($request->input('product_name'));

            Session::flash('mes_quantity_too_much', 'Produktu '.$product->product_name.' maksymalnie można wydać '.$product->quantity);

            //przekiwerowanie po nieudanej operacji
            return redirect('documents/wz/'.$id.'/edit');
        }
    }

//Usunięcie niezatwierdzonego 
    public function destroy($id)
    {
        $wz_document = Wz_document::findOrFail($id);
        $wz_document->delete();
        Session::flash('mes_wz_delete','Dokument został poprawnie usunięty');
        return redirect('documents/wz');
    } 
}




