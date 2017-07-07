<?php

namespace App;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    /**
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'name_grade', 'description'
    ];

    /*----------------------------------------
     *  Grupa posiada wiele produktów
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }


}
