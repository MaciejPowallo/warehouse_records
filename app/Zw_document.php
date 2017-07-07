<?php
namespace App;
use App\Location;
use App\Employee;
use App\Product;
use App\User;
use App\Zw_document;
use App\Product_zw_documents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zw_document extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'doc_numb', 'user_id', 'employee_id', 'locations_id', 'product_id', 'approved', 'description', 'quantity', 
    ];

    /*----------------------------------------
     *   Dokument Zw zawiera dane jednej lokalizacji
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'locations_id');
    }

    /*----------------------------------------
     *   Dokument Zw zawiera dane jednego pracownika
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }

    /*----------------------------------------
     *   Dokument Zw jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Dokument Zw posiada wiele produktów
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_zw_documents', 'zw_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }    
}