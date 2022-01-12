<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class UserController extends Controller
{
    function create (Request $request){
        // Validate Inputs
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:30',
            'cpassword' => 'required|min:5|max:30|same:password'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Hash::make($request->password);
        $save = $user->save();

        if($save) {
            $creds = $request->only('email','password');
            if(Auth::guard('web')->attempt($creds)){
                return redirect()->route('user.home');
            }
        }else{
            return redirect()->back()->with('Fail','Something went wrong, failed to register');
        }
    }

    function check(Request $request){
        // Validate Inputs
        $request->validate([
            'email'=>'required|email|exists:users,email',
            'password'=>'required|min:5|max:30'
        ],[
            'email.exists'=>'This email is not exists in our database'
        ]);

        $creds = $request->only('email','password');
        if(Auth::guard('web')->attempt($creds)){
            return redirect()->route('user.home');
        }else{
            return redirect()->route('user.login')->with('Fail','Incorrect credentials');
        }
    }

    function home(){
        $menu = Menu::get();
        return view('dashboard.user.home',['menu'=>$menu]);
    }

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
