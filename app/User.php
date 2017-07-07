<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use App\Location;
use App\Contractor;
use App\Employee;
use App\Product;
use App\Pz_document;
use App\Wz_document;
use App\Zw_document;
use App\Booking;
use App\Return_transport;

class User extends Authenticatable
{
    use Notifiable;

    /*----------------------------------------
     * Atrybuty, które można aktualizować
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'password', 'login', 'email', 'telephone', 'function', 'remember_token', 'disable',
    ];


    /*----------------------------------------
     *  Role są przypisane wielu użytkownikom
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id')->withTimestamps();
    }    

    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasRole($role)
    {
        if ($this->roles()->where('role_name', $role)->first()) {
            return true;
        }
        return false;
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele lokalizacji
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele kontrahentów
     */
    public function contractors()
    {
        return $this->hasMany('App\Contractor');
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele pracowników
     */
    public function employees()
    {
        return $this->hasMany('App\Employee');
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele produktów
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele dokumentów pz
     */
    public function pz_documents()
    {
        return $this->hasMany('App\Pz_document');
    }

    /*----------------------------------------
     *  Użytkownik tworzy wiele dokumentów wz
     */
    public function wz_documents()
    {
        return $this->hasMany('App\Wz_document');
    }   

    /*----------------------------------------
     *  Użytkownik tworzy wiele dokumentów pz
     */
    public function zw_documents()
    {
        return $this->hasMany('App\Zw_document');
    }   

    /*----------------------------------------
     *  Użytkownik tworzy wiele rezerwacji
     */
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }  

    /*----------------------------------------
     *  Użytkownik tworzy wiele transportów zwrotnych
     */
    public function transports()
    {
        return $this->hasMany('App\Return_transport');
    }   
}