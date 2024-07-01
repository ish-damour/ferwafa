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
            'password' => 'required|min:6|confirmed',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Add validation for the picture
        ]);
    
        // Handle file upload
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }
    
        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'picture' => $imageName, // Save the image name
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

    public function show()
    {
        // Logic to show the profile
        return view('profile');
    }

    public function showChangeForm()
    {
        return view('auth.passwords.change');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with('success', 'Password changed successfully');
    }
    
}
