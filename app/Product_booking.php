<?php
namespace App;
use App\Product;
use App\User;
use App\Booking;
use Illuminate\Database\Eloquent\Model;

class Product_booking extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
    	'product_id', 'booking_id', 'quantity',
    ];
}
