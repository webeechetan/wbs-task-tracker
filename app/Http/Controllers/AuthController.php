<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request){
        $user = Socialite::driver('google')->user();
        $findUser = User::where('email',$user->email)->first();
        session()->put('googleUser',$user);
        if($findUser){
            Auth::loginUsingId($findUser->id);
            return redirect()->route('dashboard');
        }else{
            $this->alert('Login Failed','Not registered with us!','danger');
            return redirect()->route('login.view');
        }
    }

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
            return redirect()->route('task-index');
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
