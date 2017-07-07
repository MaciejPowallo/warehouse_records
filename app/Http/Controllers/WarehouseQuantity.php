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
class WarehouseQuantity extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_catalog_nr = Request::get('search_catalog_nr');
        $search_product_name = Request::get('search_product_name');
        $search_name_type = Request::get('search_name_type');
        $search_name_grade = Request::get('search_name_grade');
        $search_quantity_down = Request::get('search_quantity_down');
        $search_quantity_up = Request::get('search_quantity_up');
        $search_unit = Request::get('search_unit');
        $search_price_down = Request::get('search_price_down');
        $search_price_up = Request::get('search_price_up');

      if($search_catalog_nr != ''){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['catalog_nr','like','%'.$search_catalog_nr.'%']])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['catalog_nr','like','%'.$search_catalog_nr.'%']])->latest()->paginate($counter);}

        elseif($search_product_name != ''){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['product_name','like','%'.$search_product_name.'%']])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['product_name','like','%'.$search_product_name.'%']])->latest()->paginate($counter);}

        elseif($search_unit != ''){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['unit','like','%'.$search_unit.'%']])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['unit','like','%'.$search_unit.'%']])->latest()->paginate($counter);}

//Wyszukanie ceny
        elseif(($search_price_down != '') && ($search_price_up == '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','>=', $search_price_down]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','>=', $search_price_down]])->latest()->paginate($counter);}

        elseif(($search_price_down == '') && ($search_price_up != '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','<=', $search_price_up]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','<=', $search_price_up]])->latest()->paginate($counter);}

        elseif(($search_price_down != '') && ($search_price_up != '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','>=', $search_price_down],['price','<=', $search_price_up]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['price','>=', $search_price_down],['price','<=', $search_price_up]])->latest()->paginate($counter);}

//Wyszukanie ilości
        elseif(($search_quantity_down != '') && ($search_quantity_up == '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','>=', $search_quantity_down]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','>=', $search_quantity_down]])->latest()->paginate($counter);}

        elseif(($search_quantity_down == '') && ($search_quantity_up != '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','<=', $search_quantity_up]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','<=', $search_quantity_up]])->latest()->paginate($counter);}

        elseif(($search_quantity_down != '') && ($search_quantity_up != '')){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','>=', $search_quantity_down],['quantity','<=', $search_quantity_up]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0],['quantity','>=', $search_quantity_down],['quantity','<=', $search_quantity_up]])->latest()->paginate($counter);}

// Wyszukanie po grupie produktu
        elseif($search_name_type != ''){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->join('types','types.id','=','products.type_id')->where('types.name_type','like','%'.$search_name_type.'%')->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->join('types','types.id','=','products.type_id')->select('products.*', 'types.name_type')->where('types.name_type','like','%'.$search_name_type.'%')->orderBy('products.created_at')->paginate($counter);}

// Wyszukanie po rodzaju produktu
        elseif($search_name_grade != ''){
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->join('grades','grades.id','=','products.grade_id')->where('grades.name_grade','like','%'.$search_name_grade.'%')->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->join('grades','grades.id','=','products.grade_id')->select('products.*', 'grades.name_grade')->where('grades.name_grade','like','%'.$search_name_grade.'%')->orderBy('products.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->count();
            $products = Product::where([['disable', '!=', TRUE],['quantity', '>', 0]])->latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('warehouserecords.warehouse.index')->with('products', $products)->with('counter', $counter); 
    }
}