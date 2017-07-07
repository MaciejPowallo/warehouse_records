<?php
namespace App;
use App\User;
use App\Wz_document;
use App\Zw_document;
use App\Booking;
use App\Return_transport;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'location_name', 'country', 'city', 'street', 'street_number', 'postcode', 'description', 'disable',
    ];

    /*----------------------------------------
     *   Lokalizacja jest utworzona przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *  Lokalizacja może występować na wielu wydaniach WZ
     */
    public function wz_documents()
    {
        return $this->hasMany('App\Wz_document');
    }

    /*----------------------------------------
     *  Lokalizacja może występować na wielu zwrotach ZW
     */
    public function zw_documents()
    {
        return $this->hasMany('App\Zw_document');
    }

    /*----------------------------------------
     *  Lokalizacja może występować w wielu rezerwacjach
     */
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    } 
    /*----------------------------------------
     *  Lokalizacja może występować w wielu transportach
     */
    public function transports()
    {
        return $this->hasMany('App\Booking');
    }  
}
