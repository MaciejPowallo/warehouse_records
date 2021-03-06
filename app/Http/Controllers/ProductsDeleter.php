<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Grade;
use App\Type;
use App\Product;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateProductRequest;
use App\Http\Controllers\Controller;
use Session;
class ProductsDeleter extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_catalog_nr = Request::get('search_catalog_nr');
        $search_product_name = Request::get('search_product_name');
        $search_name_type = Request::get('search_name_type');
        $search_name_grade = Request::get('search_name_grade');
        $search_unit = Request::get('search_unit');
        $search_price_down = Request::get('search_price_down');
        $search_price_up = Request::get('search_price_up');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

      if($search_catalog_nr != ''){
            $counter = Product::where([['disable', TRUE],['catalog_nr','like','%'.$search_catalog_nr.'%']])->count();
            $products = Product::where([['disable', TRUE],['catalog_nr','like','%'.$search_catalog_nr.'%']])->latest()->paginate($counter);}

        elseif($search_product_name != ''){
            $counter = Product::where([['disable', TRUE],['product_name','like','%'.$search_product_name.'%']])->count();
            $products = Product::where([['disable', TRUE],['product_name','like','%'.$search_product_name.'%']])->latest()->paginate($counter);}

        elseif($search_unit != ''){
            $counter = Product::where([['disable', TRUE],['unit','like','%'.$search_unit.'%']])->count();
            $products = Product::where([['disable', TRUE],['unit','like','%'.$search_unit.'%']])->latest()->paginate($counter);}

//Wyszukanie ceny
        elseif(($search_price_down != '') && ($search_price_up == '')){
            $counter = Product::where([['disable', TRUE],['price','>=', $search_price_down]])->count();
            $products = Product::where([['disable', TRUE],['price','>=', $search_price_down]])->latest()->paginate($counter);}

        elseif(($search_price_down == '') && ($search_price_up != '')){
            $counter = Product::where([['disable', TRUE],['price','<=', $search_price_up]])->count();
            $products = Product::where([['disable', TRUE],['price','<=', $search_price_up]])->latest()->paginate($counter);}

        elseif(($search_price_down != '') && ($search_price_up != '')){
            $counter = Product::where([['disable', TRUE],['price','>=', $search_price_down],['price','<', $search_price_up]])->count();
            $products = Product::where([['disable', TRUE],['price','>=', $search_price_down],['price','<', $search_price_up]])->latest()->paginate($counter);}


// Wyszukanie po grupie produktu
        elseif($search_name_type != ''){
            $counter = Product::where('products.disable', TRUE)->join('types','types.id','=','products.type_id')->where('types.name_type','like','%'.$search_name_type.'%')->count();
            $products = Product::where('products.disable', TRUE)->join('types','types.id','=','products.type_id')->select('products.*', 'types.name_type')->where('types.name_type','like','%'.$search_name_type.'%')->orderBy('products.created_at')->paginate($counter);}

// Wyszukanie po rodzaju produktu
        elseif($search_name_grade != ''){
            $counter = Product::where('products.disable', TRUE)->join('grades','grades.id','=','products.grade_id')->where('grades.name_grade','like','%'.$search_name_grade.'%')->count();
            $products = Product::where('products.disable', TRUE)->join('grades','grades.id','=','products.grade_id')->select('products.*', 'grades.name_grade')->where('grades.name_grade','like','%'.$search_name_grade.'%')->orderBy('products.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $products = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->select('products.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('products.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $products = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->select('products.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('products.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $products = Product::where('products.disable', TRUE)->join('users','users.id','=','products.user_id')->select('products.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('products.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Product::where('disable', TRUE)->count();
            $products = Product::where('disable', TRUE)->latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('products.delete.index')->with('products', $products)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$product =	Product::findOrFail($id);
    	return view('products.delete.show')->with('product', $product);
    } 

// Edycja elementu
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $grade_id = Grade::get()->pluck('name_grade','id');
        $type_id = Type::get()->pluck('name_type','id');
        return view('products.delete.edit')->with(compact('product', 'grade_id', 'type_id'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateProductRequest $request)
    {
        $product = Product::findOrFail($id);

        $this->validate($request, [
            'disable' => 'boolean',
         ]);

        $product -> update($request->all());

    // Dołączony grupę
        $grades = $request->input('grade_id');
        $product->grade()->associate($grades);

    //Dołaczono rodzaj
        $types = $request->input('type_id');
        $product->type()->associate($types);

    //Zapisz wszystko
        $product->save();

        //Informacje z sesji
        Session::flash('mes_product_delete', 'Produkt został poprawnie usunięty'); 

        //przekierowanie po udanej operacji
       return redirect('products');
    }
}
