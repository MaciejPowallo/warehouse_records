<?php
namespace App;
use App\Product;
use App\User;
use App\Lt_document;
use Illuminate\Database\Eloquent\Model;

class Product_lt_documents extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
    	'product_id', 'lt_id', 'quantity',
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
    public function lt()
    {
        return $this->belongsTo('App\Lt_document', 'lt_id');
    }
}
