<?php
namespace App;
use App\Location;
use App\Employee;
use App\Product;
use App\User;
use App\Wz_document;
use App\Product_wz_documents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wz_document extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'doc_numb', 'user_id', 'employee_id', 'locations_id', 'product_id', 'expend', 'approved', 'description', 'quantity', 
    ];

    /*----------------------------------------
     *   Dokument Wz zawiera dane jednej lokalizacji
     */
    public function location()
    {
        return $this->belongsTo('App\Location', 'locations_id');
    }

    /*----------------------------------------
     *   Dokument Wz zawiera dane jednego pracownika
     */
    public function employee()
    {
        return $this->belongsTo('App\Employee', 'employee_id');
    }

    /*----------------------------------------
     *   Dokument Wz jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Dokument Wz posiada wiele produktów
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_wz_documents', 'wz_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }    
}