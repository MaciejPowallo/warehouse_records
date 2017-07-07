<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Contractor;
use Illuminate\Validation\Rule;
use App\Http\Requests\CreateContractorRequest;
use Session;

class ContractorsDeleter extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_nametag = Request::get('search_nametag');
        $search_name = Request::get('search_name');
        $search_country = Request::get('search_country');
        $search_city = Request::get('search_city');
        $search_street = Request::get('search_street');
        $search_street_number = Request::get('search_street_number');
        $search_postcode = Request::get('search_postcode');
        $search_telephone = Request::get('search_telephone');
        $search_email = Request::get('search_email');
        $search_nip = Request::get('search_nip');
        $search_regon = Request::get('search_regon');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

      if($search_nametag != ''){
            $counter = Contractor::where([['disable', TRUE],['nametag','like','%'.$search_nametag.'%']])->count();
            $contractors = Contractor::where([['disable', TRUE],['nametag','like','%'.$search_nametag.'%']])->latest()->paginate($counter);}

        elseif($search_name != ''){
            $counter = Contractor::where([['disable', TRUE],['name_contractor','like','%'.$search_name.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['name_contractor','like','%'.$search_name.'%']])->latest()->paginate($counter);}

        elseif($search_country != ''){
            $counter = Contractor::where([['disable', TRUE],['country','like','%'.$search_country.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['country','like','%'.$search_country.'%']])->latest()->paginate($counter);}

        elseif($search_city != ''){
            $counter = Contractor::where([['disable', TRUE],['city','like','%'.$search_city.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['city','like','%'.$search_city.'%']])->latest()->paginate($counter);}

        elseif($search_street != ''){
            $counter = Contractor::where([['disable', TRUE],['street','like','%'.$search_street.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['street','like','%'.$search_street.'%']])->latest()->paginate($counter);}

        elseif($search_street_number != ''){
            $counter = Contractor::where([['disable', TRUE],['street_number','like','%'.$search_street_number.'%']])->count();
            $contractors = Contractor::where([['disable', TRUE],['street_number','like','%'.$search_street_number.'%']])->latest()->paginate($counter);}

        elseif($search_postcode != ''){
            $counter = Contractor::where([['disable', TRUE],['postcode','like','%'.$search_postcode.'%']])->count();
            $contractors = Contractor::where([['disable', TRUE],['postcode','like','%'.$search_postcode.'%']])->latest()->paginate($counter);}

        elseif($search_telephone != ''){
            $counter = Contractor::where([['disable', TRUE],['telephone','like','%'.$search_telephone.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['telephone','like','%'.$search_telephone.'%']])->latest()->paginate($counter);}

        elseif($search_email != ''){
            $counter = Contractor::where([['disable', TRUE],['email','like','%'.$search_email.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['email','like','%'.$search_email.'%']])->latest()->paginate($counter);}  

        elseif($search_nip != ''){
            $counter = Contractor::where([['disable', TRUE],['nip','like','%'.$search_nametag.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['nip','like','%'.$search_nip.'%']])->latest()->paginate($counter);} 

        elseif($search_regon != ''){
            $counter = Contractor::where([['disable', TRUE],['regon','like','%'.$search_regon.'%']])->count();            
            $contractors = Contractor::where([['disable', TRUE],['regon','like','%'.$search_regon.'%']])->latest()->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter =  Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();   
        	$contractors = Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->select('contractors.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('users.name')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count(); 
        	$contractors = Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->select('contractors.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('users.surname')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();   
        	$contractors = Contractor::where('contractors.disable', TRUE)->join('users','users.id','=','contractors.user_id')->select('contractors.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('users.surname')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Contractor::where('disable', TRUE)->count();  
            $contractors = Contractor::where('disable', TRUE)->latest()->paginate(30);}

    // Zwrócenie wyniku
        return view('contractors.delete.index')->with('contractors', $contractors)->with('counter', $counter);
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
	 	$contractor =	Contractor::findOrFail($id);
    	return view('contractors.delete.show')->with('contractor', $contractor);
    }

// Edycja elementu
    public function edit($id)
    {
        $contractor = Contractor::findOrFail($id);
        return view('contractors.delete.edit')->with('contractor', $contractor);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateContractorRequest $request)
    {
        $contractor = Contractor::findOrFail($id);

        $this->validate($request, [
            'disable' => 'boolean',
         ]);

        $contractor -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_contractor_delete', 'Kontrahent został dezaktywowany'); 

        //przekierowanie po udanej operacji
        return redirect('contractors');
    }
}
