<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Grade;
use App\Type;
use App\Location;
use App\Product_wz_documents;
use App\Product_zw_documents;
use App\Wz_document;
use App\Product;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateProductRequest;
use App\Http\Controllers\Controller;
use Session;
use Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class LocationQuantity extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {

        //Wybór lokalizacji
        $location = Location::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",location_name," -> ",postcode," ", city) AS location_name'),'id')->get()->sortBy('location_name')->pluck('location_name','id');

        $locations = Request::get('locations');
        $search_catalog_nr = Request::get('search_catalog_nr');
        $search_product_name = Request::get('search_product_name');

        if($search_catalog_nr != ''){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.locations_id', $locations],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.locations_id', $locations],['products.catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();
        }


        elseif($search_product_name != ''){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.locations_id', $locations],['product_name','like','%'.$search_product_name.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.locations_id', $locations],['products.product_name','like','%'.$search_product_name.'%']])->orderBy('product_id')->get();
        }

        elseif(($search_catalog_nr != '') && ($search_product_name != '')){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.locations_id', $locations],['product_name','like','%'.$search_product_name.'%'],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.locations_id', $locations],['products.product_name','like','%'.$search_product_name.'%'],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();
        }

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{

            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.locations_id', $locations]])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.locations_id', $locations]])->orderBy('product_id')->get();
        }

        // Połączenie dwóch kolekcji w jedną
        $collection = collect([$zw, $wz]);
        $wzs = $collection->collapse()->sortByDesc('product_name');
        $wzs->all();
        $counter = $wzs->count();

    // Zwrócenie wyniku
        return view('warehouserecords.location.index')->with(compact('wzs','counter','location'));
    }
}