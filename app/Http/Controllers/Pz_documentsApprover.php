<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Contractor;
use App\Product;
use App\Pz_document;
use App\Product_pz_documents;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreatePz_documentRequest;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class Pz_documentsApprover extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_nametag = Request::get('search_nametag');
        $search_name_contractor = Request::get('search_name_contractor');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');
        $search_pz_date = Request::get('search_pz_date');

        if($search_doc_numb != ''){
            $counter = Pz_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $pz_documents = Pz_document::where([['approved', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_pz_date != ''){
            $counter = Pz_document::where([['approved', TRUE],['pz_date','like','%'.$search_pz_date.'%']])->count();
            $pz_documents = Pz_document::where([['approved', TRUE],['pz_date','like','%'.$search_pz_date.'%']])->latest()->paginate($counter);}

// Wyszukanie po identyfikarotze kontrahenta
        elseif($search_nametag != ''){
            $counter = Pz_document::where('pz_documents.approved', TRUE)->join('contractors','contractors.id','=','pz_documents.contractor_id')->where('contractors.nametag','like','%'.$search_nametag.'%')->count();
            $pz_documents = Pz_document::where('pz_documents.approved', TRUE)->join('contractors','contractors.id','=','pz_documents.contractor_id')->select('pz_documents.*', 'contractors.nametag')->where('contractors.nametag','like','%'.$search_nametag.'%')->orderBy('pz_documents.created_at')->paginate($counter);}

// Wyszukanie po nazwie kontrahenta
        elseif($search_name_contractor != ''){
            $counter = Pz_document::where('pz_documents.approved', TRUE)->join('contractors','contractors.id','=','pz_documents.contractor_id')->where('contractors.name_contractor','like','%'.$search_name_contractor.'%')->count();
            $pz_documents = Pz_document::where('pz_documents.approved', TRUE)->join('contractors','contractors.id','=','pz_documents.contractor_id')->select('pz_documents.*', 'contractors.name_contractor')->where('contractors.name_contractor','like','%'.$search_name_contractor.'%')->orderBy('pz_documents.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $pz_documents = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->select('pz_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('pz_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $pz_documents = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->select('pz_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('pz_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $pz_documents = Pz_document::where('pz_documents.approved', TRUE)->join('users','users.id','=','pz_documents.user_id')->select('pz_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('pz_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Pz_document::where('approved', TRUE)->count();
            $pz_documents = Pz_document::where('approved', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.approved.pz.index')->with('pz_documents', $pz_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$pz_document =	Pz_document::findOrFail($id);
	 	$approved = $pz_document->approved;
	 	if($approved == 1){
    		return view('documents.approved.pz.show')->with('pz_document', $pz_document);
    	}
    	else{
    		return redirect('documents/pz/'.$id);
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $pz_document = Pz_document::findOrFail($id);

        return view('documents.approved.pz.edit')->with('pz_document', $pz_document);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreatePz_documentRequest $request)
    {
        $pz_document = Pz_document::findOrFail($id);

        $this->validate($request, [
            'approved' => 'boolean',
         ]);

        //Aktualizacja stanów na magazynie
        $quantity = Product_pz_documents::where('pz_id', $id)->get();
            foreach ($quantity as $qnty) {
                $products = Product::where('products.id', $qnty->product_id)->get();
                foreach ($products as $product) {

                    //Aktualizacja stanu aktualnego na magazynie
                    Product::where('products.id', $qnty->product_id)->update(['products.quantity' => $product->quantity+$qnty->quantity]);

                    //Aktualizacja stanu całkowictego na magazynie
                    Product::where('products.id', $qnty->product_id)->update(['products.total_quantity' => $product->total_quantity+$qnty->quantity]);
                }
            }

        //Aktualizacja wpisu 
        $pz_document -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('documents.approved.pz.show')->with('pz_document', $pz_document);
    }
}