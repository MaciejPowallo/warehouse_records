<?php

namespace App\Http\Controllers;
use Request;
use App\User;
use App\Role;
use App\Http\Requests\CreateUserRequest;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Support\JsonableInterface;

class UsersDeleter extends Controller
{
// Edycja elementu
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.delete.edit')->with('user', $user);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateUserRequest $request)
    {
        $user = User::findOrFail($id);

        // Anulowanie ról przydzielonch użytkownikom
        $user ->roles()->detach();

        $user -> update($request->all());

        //Informacje z sesji
        Session::flash('mes_user_delete', 'Użytkownik został usunięty'); 

        //przekierowanie po udanej operacji
        return redirect('users.delete');
    }
}