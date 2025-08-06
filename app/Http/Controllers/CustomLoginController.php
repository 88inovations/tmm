<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomLoginController extends Controller
{
    

    public function login(Request $request)
    {


        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        

      
        if (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            ];
          }else{
            $credentials = [
            'user_name' => $request->input('email'),
            'password' => $request->input('password'),
            ];
          }
          
        if (Auth::attempt($credentials)) {
            user_log_history();

            $user = Auth::user();
        if ($user->status == 1) {

            return redirect()->intended('/home');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors(['login' => 'Your account is not active.']);
        }
            
        }
        return redirect()->route('login')->withErrors(['login' => 'Invalid login credentials']);
        
    }
}

