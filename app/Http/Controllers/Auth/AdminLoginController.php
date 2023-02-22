<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function LoginView()
    {
        return view('auth.login');
    }
    public function Login(Request $request)
    {
   
        $this->validate($request, [
            'username'   => 'required',
            'password' => 'required'
            ]);
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password,'deleted_at' => null,'status'=>0]))
        {
            return redirect()->intended(route('dashboard'));
        }
        else
        {
            return redirect()->back()->withErrors(['error_message' => "Invalid username or Password"])->withInput();
        }
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('login');
    }
}
