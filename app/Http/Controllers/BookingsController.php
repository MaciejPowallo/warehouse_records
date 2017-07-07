<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Location;
use App\Product;
use App\Booking;
use App\Product_booking;
use App\Http\Requests\CreateBookingRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Session;
use Illuminate\Support\Facades\DB;

class BookingsController extends Controller
{
// Wyświetla wszystkie pozycje
    public function index()
    {
        $search_doc_numb = Request::get('search_doc_numb');
        $search_location_name = Request::get('search_location_name');
        $search_name_booked = Request::get('search_name_booked');
        $search_delivery_date = Request::get('search_delivery_date');
        $search_booking_date = Request::get('search_booking_date');
        $search_user_name = Request::get('search_user_name');
        $search_user_surname = Request::get('search_user_surname');

        if($search_doc_numb != ''){
            $counter = Booking::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $bookings = Booking::where([['approved', '!=', TRUE],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_name_booked != ''){
            $counter = Booking::where([['approved', '!=', TRUE],['name_booked','like','%'.$search_name_booked.'%']])->count();
            $bookings = Booking::where([['approved', '!=', TRUE],['name_booked','like','%'.$search_name_booked.'%']])->latest()->paginate($counter);}

        elseif($search_delivery_date != ''){
            $counter = Booking::where([['approved', '!=', TRUE],['delivery_date','like','%'.$search_delivery_date.'%']])->count();
            $bookings = Booking::where([['approved', '!=', TRUE],['delivery_date','like','%'.$search_delivery_date.'%']])->latest()->paginate($counter);}

        elseif($search_booking_date != ''){
            $counter = Booking::where([['approved', '!=', TRUE],['created_at','like','%'.$search_booking_date.'%']])->count();
            $bookings = Booking::where([['approved', '!=', TRUE],['created_at','like','%'.$search_booking_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Booking::where('bookings.approved', '!=', TRUE)->join('locations','locations.id','=','bookings.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $bookings = Booking::where('bookings.approved', '!=', TRUE)->join('locations','locations.id','=','bookings.locations_id')->select('bookings.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('bookings.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $bookings = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('bookings.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $bookings = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('bookings.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $bookings = Booking::where('bookings.approved', '!=', TRUE)->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('bookings.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Booking::where('approved', '!=', TRUE)->count();
            $bookings = Booking::where('approved', '!=', TRUE)->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('bookings.index')->with('bookings', $bookings)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $booking =  Booking::findOrFail($id);
        $approved = $booking->approved;
        $accepted = $booking->accepted;

        if($approved != 1){
            return view('bookings.show')->with('booking', $booking);
        }
        else{
        	if($accepted === NULL) {
	        	return redirect('bookings/approved/'.$id);
        	}
	        else{
	        	return redirect('bookings/mediate/'.$id);
	        }
    	}
    }


//Tworzenie nowego elemetu
    public function create()
    {
        //Wybór lokalizacji
        $location = Location::where('disable', '!=', TRUE)->select(DB::raw('CONCAT_WS("",location_name," -> ",postcode," ", city) AS location_name'),'id')->get()->sortBy('location_name')->pluck('location_name','id');

        return view('bookings.create')->with('location', $location); 
    }


//Zapisanie dodanego elementu
    public function store(CreateBookingRequest $request)
    {
        $this->validate($request, [
            'disable'           => 'boolean',
         ]);

    //Zapisanie wszystkiego z żądania
        $booking = new Booking($request->all());

    // Dołączenie lokalizacji
        $location = $request->input('location_id');
        $booking->location()->associate($location);

    //Zapisanie wszystkiego
        $booking->save();

    // Pobranie potrzebnych zmiennych
        $id =	Booking::orderBy('id', 'desc')->first()->id;
        $location_id =	Booking::orderBy('id', 'desc')->first()->locations_id; 

    // Nadanie numeru
        Booking::where('id', $id)->update(['doc_numb' => $id.'/'.$location_id.'/'.date('m/Y')]);    

    //przekierowanie po udanej operacji
    	return redirect('bookings/'.$id);
    } 

// Edycja elementu
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        //scalenie kilku kolumn w jedną i wyświetlenie jej w polu select
        
		$product_name =	Product::where([['disable', '!=', TRUE]])->select(
            DB::raw('CONCAT_WS(" "," [ ", catalog_nr," ",product_name,"] [ Ilość: ",quantity,"] [ Jednostka:", unit," ]") AS product_name'),'id')->pluck('product_name', 'id');

        return view('bookings.edit')->with(compact('booking', 'product_name'));
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateBookingRequest $request)
    {
        //wyszukanie id dokumentu
        $booking = Booking::findOrFail($id);

        //aktualizacja opisu
       	$booking->update(['description' => $request->input('description')]);

        //dodanie nowego produktu do pivota
        $booking -> products() -> attach($request->input('product_name'));
        
        //znajdujemy ostatni produkt w pivocie z danej rezerwacji i dopisujemy do niego ilość
        $id = Product_booking::where('booking_id', $id)->orderBy('id', 'desc')->first()->id;
     	Product_booking::where('id', $id)->update(['quantity' => ($request->input('quantity'))]);

        //przekierowanie po udanej operacji
        return view('bookings.show')->with('booking', $booking);

    }

//Usunięcie niezatwierdzonego 
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        Session::flash('mes_booking_delete','Dokument został poprawnie usunięty');
        return redirect('bookings');
    } 
}




