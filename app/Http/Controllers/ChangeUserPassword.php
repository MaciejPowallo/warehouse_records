<?php
namespace App\Http\Controllers;
use Request;
use App\User;
use App\Role;
use App\Http\Requests\CreateUserRequest;
use Session;
use Illuminate\Support\Facades\Hash;

class ChangeUserPassword extends Controller
{

// Edycja elementu
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('changepassword.edit')->with('user', $user);
    }

//Zapisanie edytowanego elementu
    public function update($id, CreateUserRequest $request)
    {
        $this->validate($request, [
            'password' => 'required|min:8|max:20',
         ]);

        $user = User::findOrFail($id);

        // Zapisywanie zmian oraz Haszowanie podanego hasła
        $user -> update([
            'password' => Hash::make($request->password),
            $request->all()
            ]);

        Session::flash('mes_user_update', 'Hasło zostało zmienione'); 
        return view('users.show')->with('user', $user);
    }
}
