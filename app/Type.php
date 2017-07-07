<?php
namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'name_type', 'description'
    ];

    /*----------------------------------------
     *  Typ posiada wiele produktów
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

}
