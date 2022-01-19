<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use Illuminate\Support\Facades\DB;

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
            return redirect()->route('login')->with('Fail','Incorrect credentials');
        }
    }

    function transaction(){
        $unpaidTransaction = DB::table('transactions')
                            ->join('transaction_details','transaksiID','=','transactions.id')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','=','Unpaid')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('transactions.id as id','transactions.totalHarga as totalHarga')
                            ->get();
        $unpaidTransaction2 = DB::table('transaction_details')
                            ->join('transactions','transactions.id','=','transaction_details.transaksiID')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','=','Unpaid')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('menus.namaMenu as namaMenu')
                            ->get();
        $ongoingTransaction = DB::table('transactions')
                            ->join('transaction_details','transaksiID','=','transactions.id')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','!=','Unpaid')
                            ->where('status','!=','Delivered')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('transactions.id as id','transactions.totalHarga as totalHarga')
                            ->get();
        $ongoingTransaction2 = DB::table('transaction_details')
                            ->join('transactions','transactions.id','=','transaction_details.transaksiID')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','=','Delivered')
                            ->where('status','=','Cooked')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('menus.namaMenu as namaMenu')
                            ->get();
        $historyTransaction = DB::table('transactions')
                            ->join('transaction_details','transaksiID','=','transactions.id')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','=','Delivered')
                            ->where('status','=','Cooked')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('transactions.id as id','transactions.totalHarga as totalHarga')
                            ->get();
        $historyTransaction2 = DB::table('transaction_details')
                            ->join('transactions','transactions.id','=','transaction_details.transaksiID')
                            ->join('menus','menus.id','=','transaction_details.barangID')
                            ->where('status','!=','Unpaid')
                            ->where('status','!=','Delivered')
                            ->where('pembeliID','=',Auth::user()->id)
                            ->select('menus.namaMenu as namaMenu')
                            ->get();
        return view('dashboard.user.transaction',['unpaidTransaction'=>$unpaidTransaction,'unpaidTransaction2'=>$unpaidTransaction2,'ongoingTransaction'=>$ongoingTransaction,'ongoingTransaction2'=>$ongoingTransaction2,'historyTransaction'=>$historyTransaction,'historyTransaction2'=>$historyTransaction2]);
    }

    function home(){
        $menu = Menu::get();
        return view('dashboard.user.home',['menu'=>$menu]);
    }

    function portofolio($id){
        $menu = Menu::where('id',$id)->first();
        return view('dashboard.user.portofolio',['menu'=>$menu]);
    }

    function logout(){
        Auth::guard('web')->logout();
        return redirect('/');
    }
}
