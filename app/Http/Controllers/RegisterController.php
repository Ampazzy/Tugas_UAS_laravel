<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {

        //validate form
        $this->validate($request, [
            'name' => 'required|unique:users,name',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|',
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required|numeric',
        ]);

        //create post
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => 2,
        ]);

        Profile::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);


        return redirect('/login')->with('success', 'Registrasi sukses, silahkan melakukan login!');
    }
}