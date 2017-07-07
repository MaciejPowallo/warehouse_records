<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Product;
use App\Lt_document;
use App\Product_lt_documents;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateLt_documentRequest;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class Lt_documentsApprover extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_cause = Request::get('search_cause');
        $search_lt_date = Request::get('search_lt_date');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_doc_numb != ''){
            $counter = Lt_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $lt_documents = Lt_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_cause != ''){
            $counter = Lt_document::where([['approved', TRUE],['expend','like','%'.$search_cause.'%']])->count();
            $lt_documents = Lt_document::where([['approved', TRUE],['expend','like','%'.$search_cause.'%']])->latest()->paginate($counter);}

        elseif($search_lt_date != ''){
            $counter = Lt_document::where([['approved', TRUE],['created_at','like','%'.$search_lt_date.'%']])->count();
            $lt_documents = Lt_document::where([['approved', TRUE],['created_at','like','%'.$search_lt_date.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $lt_documents = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('lt_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $lt_documents = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('lt_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $lt_documents = Lt_document::where('lt_documents.approved', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('lt_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Lt_document::where('approved', TRUE)->count();
            $lt_documents = Lt_document::where('approved', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.approved.lt.index')->with('lt_documents', $lt_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$lt_document =	Lt_document::findOrFail($id);
	 	$approved = $lt_document->approved;
	 	if($approved == 1){
    		return view('documents.approved.lt.show')->with('lt_document', $lt_document);
    	} 
    	else{
    		return redirect('documents/lt/'.$id);
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $lt_document = Lt_document::findOrFail($id);

        return view('documents.approved.lt.edit')->with('lt_document', $lt_document);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateLt_documentRequest $request)
    {
        $lt_document = Lt_document::findOrFail($id);

        $this->validate($request, [
            'approved' => 'boolean',
         ]);

        //Aktualizacja stanów na magazynie
        $quantity = Product_lt_documents::where('lt_id', $id)->get();
            foreach ($quantity as $qnty) {
                $products = Product::where('products.id', $qnty->product_id)->get();
                foreach ($products as $product) {

                    //Aktualizacja stanu aktualnego na magazynie
                    Product::where('products.id', $qnty->product_id)->update(['products.total_quantity' => $product->total_quantity-$qnty->quantity]);

                    //Aktualizacja stanu całkowictego na magazynie
                    Product::where('products.id', $qnty->product_id)->update(['products.total_quantity' => $product->total_quantity-$qnty->quantity]);
                }
            }
            
        //aktualizacja wpisu 
        $lt_document -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('documents.approved.lt.show')->with('lt_document', $lt_document);
    }
}