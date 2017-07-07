<?php

namespace App;
use App\User;
use App\Pz_document;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    /*----------------------------------------
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'nametag', 'name_contractor', 'country', 'city', 'street', 'street_number', 'postcode', 'telephone', 'email', 'nip', 'regon', 'description', 'disable',
    ];

 

    /*----------------------------------------
     *   Kontrahent jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *  Kontrahent może występować na wielu dokumantach pezyjęcia PZ
     */
    public function pz_documents()
    {
        return $this->hasMany('App\Pz_document');
    }

}
