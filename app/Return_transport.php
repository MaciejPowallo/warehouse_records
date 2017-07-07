<?php
namespace App;
use App\Location;
use App\Product;
use App\User;
use App\Product_return_transports;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Return_transport extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'doc_numb', 'user_id', 'employee_id', 'locations_id', 'product_id', 'driver', 'vehicle', 'transport_date', 'accepted', 'approved', 'approved_by', 'reason_refusal', 'description', 'quantity', 
    ];

    /*----------------------------------------
     *   Transport zwrotny jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Transport zwrotny zawiera dane jednej lokalizacji
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'locations_id');
    }

    /*----------------------------------------
     *   Transport zwrotny zawiera dane jednego pracownika
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }

    /*----------------------------------------
     *   Transport zwrotny posiada wiele produktów
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_return_transports', 'transport_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }   
}