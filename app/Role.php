<?php
namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/*
		Role są przypisane wielu użytkownikom
	 */
    public function user()
    {
        return $this->belongsToMany('App\User', 'user_role', 'role_id', 'user_id')->withTimestamps();
    }    
}
