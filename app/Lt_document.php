<?php
namespace App;
use App\Role;
use App\Product;
use App\User;
use App\Lt_document;
use App\Product_lt_documents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lt_document extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'doc_numb', 'user_id', 'product_id', 'cause', 'approved', 'description', 'quantity', 
    ];

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
        return $this->belongsToMany('App\Product', 'product_lt_documents', 'lt_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }    
}