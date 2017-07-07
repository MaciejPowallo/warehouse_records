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

class Wz_documentsApprover extends Controller
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
            $counter = Wz_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $wz_documents = Wz_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_expend != ''){
            $counter = Wz_document::where([['approved', TRUE],['expend','like','%'.$search_expend.'%']])->count();
            $wz_documents = Wz_document::where([['approved', TRUE],['expend','like','%'.$search_expend.'%']])->latest()->paginate($counter);}

        elseif($search_wz_date != ''){
            $counter = Wz_document::where([['approved', TRUE],['updated_at','like','%'.$search_wz_date.'%']])->count();
            $wz_documents = Wz_document::where([['approved', TRUE],['updated_at','like','%'.$search_wz_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('locations','locations.id','=','wz_documents.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('locations','locations.id','=','wz_documents.locations_id')->select('wz_documents.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('employees','employees.id','=','wz_documents.employee_id')->select('wz_documents.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('wz_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('wz_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $wz_documents = Wz_document::where('wz_documents.approved', TRUE)->join('users','users.id','=','wz_documents.user_id')->select('wz_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('wz_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Wz_document::where('approved', TRUE)->count();
            $wz_documents = Wz_document::where('approved', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.approved.wz.index')->with('wz_documents', $wz_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$wz_document =	Wz_document::findOrFail($id);
	 	$approved = $wz_document->approved;
	 	if($approved == 1){
    		return view('documents.approved.wz.show')->with('wz_document', $wz_document);
    	}
    	else{
    		return redirect('documents/wz/'.$id);
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $wz_document = Wz_document::findOrFail($id);

        return view('documents.approved.wz.edit')->with('wz_document', $wz_document);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateWz_documentRequest $request)
    {
        $wz_document = Wz_document::findOrFail($id);

        $this->validate($request, [
            'approved' => 'boolean',
         ]);

        //Aktualizacja stanu aktualnego na magazynie
        $quantity = Product_wz_documents::where('wz_id', $id)->get();
            foreach ($quantity as $qnty) {
                $products = Product::where('products.id', $qnty->product_id)->get();
                foreach ($products as $product) {
                    Product::where('products.id', $qnty->product_id)->update(['products.quantity' => $product->quantity-$qnty->quantity]);
                }
            }

    // Pobranie typu dokumentu
        $type = Wz_document::orderBy('id', 'desc')->first()->expend;

    //Aktualizacja stanu całkowictego na magazynie gdy jest to wydanie do zużycia
        if($type == 1){    
            $quantity = Product_wz_documents::where('wz_id', $id)->get();
            foreach ($quantity as $qnty) {
                $products = Product::where('products.id', $qnty->product_id)->get();
                foreach ($products as $product) {
                    Product::where('products.id', $qnty->product_id)->update(['products.total_quantity' => $product->total_quantity-$qnty->quantity]);
                }
            }
        } 
            
        //aktualizacja wpisu 
        $wz_document -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('documents.approved.wz.show')->with('wz_document', $wz_document);
    }
}