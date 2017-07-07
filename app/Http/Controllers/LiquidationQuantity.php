<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Grade;
use App\Type;
use App\Product_lt_documents;
use App\Lt_document;
use App\Product;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateProductRequest;
use App\Http\Controllers\Controller;
use Session;
use Eloquent\Collection;
use Illuminate\Support\Facades\DB;


class LiquidationQuantity extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_catalog_nr = Request::get('search_catalog_nr');
        $search_product_name = Request::get('search_product_name');
        $search_name_type = Request::get('search_name_type');
        $search_name_grade = Request::get('search_name_grade');
        $search_quantity_down = Request::get('search_quantity_down');
        $search_quantity_up = Request::get('search_quantity_up');
        $search_unit = Request::get('search_unit');
        $search_price_down = Request::get('search_price_down');
        $search_price_up = Request::get('search_price_up');

      	if($search_doc_numb != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['lt_documents.doc_numb','like','%'.$search_doc_numb.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['lt_documents.doc_numb','like','%'.$search_doc_numb.'%']])->orderBy('product_id')->paginate($counter);}      

        if($search_catalog_nr != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.catalog_nr','like','%'.$search_catalog_nr.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->paginate($counter);}


        elseif($search_product_name != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.product_name','like','%'.$search_product_name.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.product_name','like','%'.$search_product_name.'%']])->orderBy('product_id')->paginate($counter);}

        elseif($search_unit != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.unit','like','%'.$search_unit.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.unit','like','%'.$search_unit.'%']])->orderBy('product_id')->paginate($counter);}

//Wyszukanie ceny
        elseif(($search_price_down != '') && ($search_price_up == '')){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.price','>=', $search_price_down]])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.price','>=', $search_price_down]])->orderBy('product_id')->paginate($counter);}

        elseif(($search_price_down == '') && ($search_price_up != '')){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.price','<=', $search_price_up]])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.price','<=', $search_price_up]])->orderBy('product_id')->paginate($counter);}

        elseif(($search_price_down != '') && ($search_price_up != '')){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->where([['lt_documents.approved', 1],['products.price','>=', $search_price_down],['products.price','<=', $search_price_up]])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['products.price','>=', $search_price_down],['products.price','<=', $search_price_up]])->orderBy('product_id')->paginate($counter);}

//Wyszukanie ilości
        elseif(($search_quantity_down != '') && ($search_quantity_up == '')){
            $counter = Product_lt_documents::where('quantity','>=', $search_quantity_down)->count();
            $products = Product_lt_documents::where('quantity','>=', $search_quantity_down)->latest()->paginate($counter);}

        elseif(($search_quantity_down == '') && ($search_quantity_up != '')){
            $counter = Product_lt_documents::where('quantity','<=', $search_quantity_up)->count();
            $products = Product_lt_documents::where('quantity','<=', $search_quantity_up)->latest()->paginate($counter);}

        elseif(($search_quantity_down != '') && ($search_quantity_up != '')){
            $counter = Product_lt_documents::where([['quantity','>=', $search_quantity_down],['quantity','<=', $search_quantity_up]])->count();
            $products = Product_lt_documents::where([['quantity','>=', $search_quantity_down],['quantity','<=', $search_quantity_up]])->latest()->paginate($counter);}

// Wyszukanie po grupie produktu
        elseif($search_name_type != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->join('types','types.id','=','products.type_id')->where([['lt_documents.approved', 1],['types.name_type','like','%'.$search_name_type.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->join('types','types.id','=','products.type_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['types.name_type','like','%'.$search_name_type.'%']])->orderBy('product_id')->paginate($counter);}

// Wyszukanie po rodzaju produktu
        elseif($search_name_grade != ''){
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->join('grades','grades.id','=','products.grade_id')->where([['lt_documents.approved', 1],['grades.name_grade','like','%'.$search_name_grade.'%']])->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->join('grades','grades.id','=','products.grade_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price')->where([['lt_documents.approved', 1],['grades.name_grade','like','%'.$search_name_grade.'%']])->orderBy('product_id')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->where('lt_documents.approved', 1)->count();

            $products = Product_lt_documents::join('lt_documents','lt_documents.id','=','lt_id')->join('products','products.id','=','product_id')->select('lt_documents.*', 'product_lt_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id', 'products.price', 'products.unit')->where('lt_documents.approved', 1)->orderBy('product_id')->paginate(30);}

    // Zwrócenie wyniku
        return view('warehouserecords.liquidation.index')->with(compact('products', 'counter')); 
    }
}