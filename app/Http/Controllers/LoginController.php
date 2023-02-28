<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Comprobamos que las credenciales sean correctas
        if(!auth()->attempt($request->only('email', 'password'), $request->remember)) {
            return back()->with('mesanje', 'Credenciales Incorrectas');
        }

        //todo: Reescribir el nuevo password

        // Le pasamos al endpint post.index el username para evitar el error
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
