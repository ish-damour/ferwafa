<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Authmanager extends Controller
{
    public function login()
    {
        return view('login');
    }
  
    public function registration()
    {
        return view('registration');
    }

    
   
    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home'));
        } 
        return redirect(route('login'))->with('error', 'Invalid credentials');
    }

    public function registrationPost(Request $request)
    {
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // Added password confirmation
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ];

        $user = User::create($data);

        if (!$user) {
            return redirect(route('registration'))->with('error', 'Failed to register');
        }

        return redirect(route('login'))->with('success', 'Registration successful');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }
    
}
