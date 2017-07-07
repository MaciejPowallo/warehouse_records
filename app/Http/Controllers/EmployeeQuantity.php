<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Grade;
use App\Type;
use App\Employee;
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


class EmployeeQuantity extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {

        //Wybór pracownika
        $employee = Employee::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",surname_empl," ",name_empl, " PESEL: ", pesel) AS surname_empl'),'id')->get()->sortBy('surname_empl')->pluck('surname_empl','id');


        $employees = Request::get('employees');
        $search_catalog_nr = Request::get('search_catalog_nr');
        $search_product_name = Request::get('search_product_name');

        if($search_catalog_nr != ''){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.employee_id', $employees],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.employee_id', $employees],['products.catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();
        }


        elseif($search_product_name != ''){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.employee_id', $employees],['product_name','like','%'.$search_product_name.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.employee_id', $employees],['products.product_name','like','%'.$search_product_name.'%']])->orderBy('product_id')->get();
        }

        elseif(($search_catalog_nr != '') && ($search_product_name != '')){
            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.employee_id', $employees],['product_name','like','%'.$search_product_name.'%'],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.employee_id', $employees],['products.product_name','like','%'.$search_product_name.'%'],['catalog_nr','like','%'.$search_catalog_nr.'%']])->orderBy('product_id')->get();
        }

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{

            $zw = Product_zw_documents::join('zw_documents','zw_documents.id','=','zw_id')->join('products','products.id','=','product_id')->select('zw_documents.*', 'product_zw_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['zw_documents.approved', 1],['zw_documents.employee_id', $employees]])->orderBy('product_id')->get();

            $wz = Product_wz_documents::join('wz_documents','wz_documents.id','=','wz_id')->join('products','products.id','=','product_id')->select('wz_documents.*', 'product_wz_documents.*', 'products.catalog_nr', 'products.product_name',  'products.unit', 'products.grade_id', 'products.type_id', 'products.id')->where([['wz_documents.expend', 0],['wz_documents.approved', 1],['wz_documents.employee_id', $employees]])->orderBy('product_id')->get();
        }

        // Połączenie dwóch kolekcji w jedną
        $collection = collect([$zw, $wz]);
        $wzs = $collection->collapse()->sortByDesc('product_name');
        $wzs->all();
        $counter = $wzs->count();

    // Zwrócenie wyniku
        return view('warehouserecords.employee.index')->with(compact('wzs','counter','employee'));
    }
}