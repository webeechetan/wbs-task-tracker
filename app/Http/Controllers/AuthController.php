<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function createUser()
    {
        //return 'create user form';

        // return view('admin.user.create');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('dashboard');
        }else{
            $this->alert('Login Failed','Invalid Email or Password','danger');
            return redirect()->route('login.view');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.view');
    }
}
