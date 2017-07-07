<?php
namespace App;
use App\User;
use App\Wz_document;
use App\Zw_document;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Atrybuty tabeli, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'pesel', 'name_empl', 'surname_empl', 'email', 'telephone', 'function', 'disable',
    ];

    /*
     *   Pracownik jest utworzony przez jednego użytkownika
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /*----------------------------------------
     *  Pracownik może występować na wielu wydaniach WZ
     */
    public function wz_documents()
    {
        return $this->hasMany('App\Wz_document');
    }

    /*----------------------------------------
     *  Pracownik może występować na wielu zwrotach ZW 
     */
    public function Zw_documents()
    {
        return $this->hasMany('App\Zw_document');
    }

    /*----------------------------------------
     *  Pracownik może występować na wielu transportach zwrotnych
     */
    public function transports()
    {
        return $this->hasMany('App\Zw_document');
    }
}