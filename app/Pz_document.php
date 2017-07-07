<?php
namespace App;
use App\User;
use App\Product;
use App\Contractor;
use App\Pz_document;
use App\Product_pz_documents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pz_document extends Model
{
    use SoftDeletes;
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'contractor_id', 'product_id', 'pz_id', 'quantity', 'doc_numb', 'pz_date', 'approved', 'description', 'quantity'
    ];

    protected $dates = ['deleted_at'];
    /*----------------------------------------
     *   Dokument Pz zawiera dane jednego kontahenta
     */
    public function contractor()
    {
        return $this->belongsTo('App\Contractor', 'contractor_id');
    }

    /*----------------------------------------
     *   Dokument Pz jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *   Dokument PZ posiada wiele produktów
     */
    public function products()
    {
        return $this->belongsToMany('App\Product', 'product_pz_documents', 'pz_id', 'product_id')->withPivot('quantity')->withTimestamps();
    }   

}
