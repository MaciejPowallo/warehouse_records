<?php
namespace App;
use App\Location;
use App\Employee;
use App\Product;
use App\User;
use App\Wz_document;
use Illuminate\Database\Eloquent\Model;

class Product_wz_documents extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
    	'product_id', 'wz_id', 'quantity',
    ];

    /* Dany wpis dokumetu ma przypisany jeden produkt
     *   
     */
    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id');
    }

    /*----------------------------------------
     *  Dany wpis dokumetu ma przypisany jeden dokumet wz 
     */
    public function wz()
    {
        return $this->belongsTo('App\Wz_document', 'wz_id');
    }
}
