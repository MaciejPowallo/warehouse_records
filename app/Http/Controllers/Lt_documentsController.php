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

class Lt_documentsController extends Controller
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
            $counter = Lt_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $lt_documents = Lt_document::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_cause != ''){
            $counter = Lt_document::where([['approved', '!=', TRUE],['expend','like','%'.$search_cause.'%']])->count();
            $lt_documents = Lt_document::where([['approved', '!=', TRUE],['expend','like','%'.$search_cause.'%']])->latest()->paginate($counter);}

        elseif($search_lt_date != ''){
            $counter = Lt_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_lt_date.'%']])->count();
            $lt_documents = Lt_document::where([['approved', '!=', TRUE],['created_at','like','%'.$search_lt_date.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $lt_documents = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('lt_documents.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $lt_documents = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('lt_documents.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $lt_documents = Lt_document::where('lt_documents.approved', '!=', TRUE)->join('users','users.id','=','lt_documents.user_id')->select('lt_documents.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('lt_documents.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Lt_document::where('approved', '!=', TRUE)->count();
            $lt_documents = Lt_document::where('approved', '!=', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('documents.lt.index')->with('lt_documents', $lt_documents)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $lt_document =  Lt_document::findOrFail($id);
        $approved = $lt_document->approved;
        if($approved != 1){
            return view('documents.lt.show')->with('lt_document', $lt_document);
        }
        else{
            return redirect('documents/approved/lt/'.$id);
        }
    }

//Tworzenie nowego elemetu
    public function create()
    {
        return view('documents.lt.create');
    }

//Zapisanie dodanego elementu
    public function store(CreateLt_documentRequest $request)
    {
        $this->validate($request, [
            'cause'       		=> 'required|max:100|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{1,})$/',
            'description'       => 'max:250|min:5|regex:/^([\wąćęłńóśźżĄĆĘŁŃÓŚŹŻ\(\)\+\-.,:;=?!@&#%\[\]\/\^\$" ]{5,})$/',
            'disable'           => 'boolean',
         ]);

    //Zapisanie wszystkiego z żądania
        $lt_documents = new Lt_document($request->all());
        $lt_documents->save();

    // Pobranie potrzebnych zmiennych
        $id =	Lt_document::orderBy('id', 'desc')->first()->id;

    //Ndanie numeru
     	Lt_document::where('id', $id)->update(['doc_numb' => 'LT/'.$id.'/'.date('m/Y')]);  

    //przekierowanie po udanej operacji
    	return redirect('documents/lt/'.$id);
    } 

// Edycja elementu
    public function edit($id)
    {
        $lt_document = Lt_document::findOrFail($id);

        //scalenie kilku kolumn w jedną i wyświetlenie jej w polu select
		$product_name =	Product::where([['quantity', '>', 0],['disable', '!=', TRUE]])->select(
            DB::raw('CONCAT_WS("",catalog_nr," || ",product_name," || Ilość: ",quantity, " || ", unit," po ",price," PLN") AS product_name'),'id')->pluck('product_name', 'id');

        return view('documents.lt.edit')->with(compact('lt_document', 'product_name'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateLt_documentRequest $request)
    {
        //wyszukanie id dokumentu
        $lt_document = Lt_document::findOrFail($id);

        //dodanie nowego produktu do pivota
        $lt_document -> products() -> attach($request->input('product_name'));

        //pobieram dane z pivota oraz tabeli produkty
        $quantity = Product_lt_documents::where('lt_id', $id)->orderBy('id', 'desc')->first();
        $product = Product::where('id', $quantity->product_id)->first();
        
        if(($request->input('quantity')) <= $product->quantity)
        {
            //Pobieram ostatni produkt w pivocie z danego dokumentu Lt i dopisuję do niego ilość
            $id =	Product_lt_documents::where('lt_id', $id)->orderBy('id', 'desc')->first()->id;
     		Product_lt_documents::where('id', $id)->update(['quantity' => ($request->input('quantity'))]);

            //przekierowanie po udanej operacji
            return view('documents.lt.show')->with('lt_document', $lt_document);
        }
        else
        {
            //skasuj ostatni wpis
            $lt_document -> products() -> detach($request->input('product_name'));

            Session::flash('mes_quantity_too_much_lt', 'Produktu '.$product->product_name.' maksymalnie można wydać '.$product->quantity);

            //przekiwerowanie po nieudanej operacji
            return redirect('documents/lt/'.$id.'/edit');
        }
    }

//Usunięcie niezatwierdzonego 
    public function destroy($id)
    {
        $lt_document = Lt_document::findOrFail($id);
        $lt_document->delete();
        Session::flash('mes_lt_delete','Dokument został poprawnie usunięty');
        return redirect('documents/lt');
    } 
}