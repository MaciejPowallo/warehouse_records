<?php
namespace App;
use App\Location;
use App\Product;
use App\User;
use App\Product_booking;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'doc_numb', 'user_id', 'locations_id', 'product_id', 'name_booked', 'surname_booked', 'delivery_date', 'accepted', 'approved', 'approved_by', 'reason_refusal', 'description', 'quantity', 
    ];

    /*----------------------------------------
     *   Rezerwacja jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Rezerwacja zawiera dane jednej lokalizacji
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'locations_id');
    }


    /*----------------------------------------
     *   Rezerwacja posiada wiele produktów
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_bookings', 'booking_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }   
}
