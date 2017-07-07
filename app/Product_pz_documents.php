<?php
namespace App;
use App\User;
use App\Product;
use App\Contractor;
use App\Pz_document;
use Illuminate\Database\Eloquent\Model;

class Product_pz_documents extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
    	'product_id', 'pz_id', 'quantity',
    ];
}
