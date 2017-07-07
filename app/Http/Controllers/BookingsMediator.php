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

class BookingsMediator extends Controller
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
            $counter = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['doc_numb','like','%'.$search_doc_numb.'%']])->count();
            $bookings = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['doc_numb','like','%'.$search_doc_numb.'%']])->latest()->paginate($counter);}

        elseif($search_name_booked != ''){
            $counter = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['name_booked','like','%'.$search_name_booked.'%']])->count();
            $bookings = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['name_booked','like','%'.$search_name_booked.'%']])->latest()->paginate($counter);}

        elseif($search_delivery_date != ''){
            $counter = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['delivery_date','like','%'.$search_delivery_date.'%']])->count();
            $bookings = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['delivery_date','like','%'.$search_delivery_date.'%']])->latest()->paginate($counter);}

        elseif($search_booking_date != ''){
            $counter = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['created_at','like','%'.$search_booking_date.'%']])->count();
            $bookings = Booking::where([['approved', TRUE],['accepted', '!=', NULL],['created_at','like','%'.$search_booking_date.'%']])->latest()->paginate($counter);}

    // Wyszukanie po lokalizacji
        elseif($search_location_name != ''){
            $counter = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('locations','locations.id','=','bookings.locations_id')->where('locations.location_name','like','%'.$search_location_name.'%')->count();
            $bookings = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('locations','locations.id','=','bookings.locations_id')->select('bookings.*', 'locations.location_name')->where('locations.location_name','like','%'.$search_location_name.'%')->orderBy('bookings.created_at')->paginate($counter);}

    //Wyszukiwanie po imieniu i nazwisku użytkownika, który dodał rekord
        elseif(($search_user_name != '') && ($search_user_surname == '')){
            $counter = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->where('users.name','like','%'.$search_user_name.'%')->count();
            $bookings = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where('users.name','like','%'.$search_user_name.'%')->orderBy('bookings.created_at')->paginate($counter);}

        elseif(($search_user_surname != '') && ($search_user_name == '')){
            $counter = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->where('users.surname','like','%'.$search_user_surname.'%')->count();
            $bookings = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where('users.surname','like','%'.$search_user_surname.'%')->orderBy('bookings.created_at')->paginate($counter);}

        elseif(($search_user_name != '') && ($search_user_surname != '')){
            $counter = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->count();
            $bookings = Booking::where([['bookings.approved', TRUE],['bookings.accepted', '!=', NULL]])->join('users','users.id','=','bookings.user_id')->select('bookings.*', 'users.name', 'users.surname')->where([['users.name','like','%'.$search_user_name.'%'],['users.surname','like','%'.$search_user_surname.'%']])->orderBy('bookings.created_at')->paginate($counter);}

    // Wynik zapytanie bez wyszukiwania szczegółów
        else{
            $counter = Booking::where([['approved', TRUE],['accepted', '!=', NULL]])->count();
            $bookings = Booking::where([['approved', TRUE],['accepted', '!=', NULL]])->latest()->paginate(30);}

        // Zwrócenie wyniku
            return view('bookings.mediate.index')->with('bookings', $bookings)->with('counter', $counter); 
    }

//Wyświetla pojedynczą pozycję
    public function show($id)
    {
        $booking =  Booking::findOrFail($id);
        $approved = $booking->approved;
        $accepted = $booking->accepted;

        if($approved != 1){
            return redirect('bookings/'.$id);
        }
        else{
        	if($accepted === NULL) {
				return redirect('bookings/approved/'.$id);
        	}
	        else{
        		return view('bookings.mediate.show')->with('booking', $booking);
	        }
    	}
    }

// Edycja elementu
    public function edit($id)
    {
        $booking = Booking::findOrFail($id);

        return view('bookings.mediate.edit')->with('booking', $booking);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateBookingRequest $request)
    {
        $booking = Booking::findOrFail($id);

        $this->validate($request, [
            'accepted' => 'boolean',
         ]);

        //aktualizacja wpisu 
        $booking -> update($request->all());

        //przekierowanie po udanej operacji
    	return view('bookings.mediate.show')->with('booking', $booking);
    }
}
