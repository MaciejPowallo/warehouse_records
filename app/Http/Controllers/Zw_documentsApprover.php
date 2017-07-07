<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use App\Employee;
use App\Product;
use App\Zw_document;
use App\Product_zw_documents;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateZw_documentRequest;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class Zw_documentsApprover extends Controller
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
            $counter = Zw_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $zw_documents = Zw_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_zw_date != ''){
            $counter = Zw_document::where([['approved', TRUE],['updated_at','like','%'.$search_zw_date.'%']])->count();
            $zw_documents = Zw_document::where([['approved', TRUE],['updated_at','like','%'.$search_zw_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('locations','locations.id','=','zw_documents.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('locations','locations.id','=','zw_documents.locations_id')->select('zw_documents.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku pracownika
        elseif(($search_name_empl != '') && ($search_surname_empl == '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where('employees.name_empl','like','%'.$search_name_empl.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.name_empl','like','%'.$search_name_empl.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_surname_empl != '') && ($search_name_empl == '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where('employees.surname_empl','like','%'.$search_surname_empl.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_name_empl != '') && ($search_surname_empl != '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('employees','employees.id','=','zw_documents.employee_id')->select('zw_documents.*', 'employees.name_empl', 'employees.surname_empl')->where([['employees.name_empl','like','%'.$search_name_empl.'%'],['employees.surname_empl','like','%'.$search_surname_empl.'%']])->orderBy('zw_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('zw_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $zw_documents = Zw_document::where('zw_documents.approved', TRUE)->join('users','users.id','=','zw_documents.user_id')->select('zw_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('zw_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Zw_document::where('approved', TRUE)->count();
            $zw_documents = Zw_document::where('approved', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.approved.zw.index')->with('zw_documents', $zw_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$zw_document =	Zw_document::findOrFail($id);
	 	$approved = $zw_document->approved;
	 	if($approved == 1){
    		return view('documents.approved.zw.show')->with('zw_document', $zw_document);
    	}
    	else{
    		return redirect('documents/zw/'.$id);
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $zw_document = Zw_document::findOrFail($id);

        return view('documents.approved.zw.edit')->with('zw_document', $zw_document);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateZw_documentRequest $request)
    {
        $zw_document = Zw_document::findOrFail($id);

        $this->validate($request, [
            'approved' => 'boolean',
         ]);

        //Aktualizacaja stanu na magazynie
        $quantity = Product_zw_documents::where('zw_id', $id)->get();
            foreach ($quantity as $qnty) {
                $products = Product::where('products.id', $qnty->product_id)->get();
                foreach ($products as $product) {
                    Product::where('products.id', $qnty->product_id)->update(['products.quantity' => $product->quantity+$qnty->quantity]);
                }
            }

        //aktualizacja wpisu 
        $zw_document -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('documents.approved.zw.show')->with('zw_document', $zw_document);
    }
}