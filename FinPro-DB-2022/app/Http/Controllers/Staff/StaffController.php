<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    function check(Request $request){
        //Validate Inputs
        $request->validate([
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:5|max:30'
        ],[
            'email.exists' => 'You are not eligible to enter the next stage'
        ]);

        $role = Staff::where('email','=',$request->email)->first();
        $creds = $request->only('email','password');
        if($role->jobDesc == 'Admin'){
            $guard = 'admin';
        }else if($role->jobDesc = 'Staff'){
            $guard = 'staff';
        }

        if(Auth::guard($guard)->attempt($creds)){
            return redirect()->route($guard.'.home');
        }else{
            return redirect()->route('staff.login')->with('Fail','Incorrect credentials');
        }
    }

    function logout(){
        Auth::guard('staff')->logout();
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
