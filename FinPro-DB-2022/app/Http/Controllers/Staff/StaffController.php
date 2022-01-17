<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    function check(Request $request){
        //Validate Inputs
        $request->validate([
            'email' => 'required|email|exists:staff,email',
            'password' => 'required|min:5|max:30'
        ],[
            'email.exists' => 'You are not eligible to enter the next stage'
        ]);

        $role = Staff::where('email','=',$request->email)->first();
        $creds = $request->only('email','password');
        if($role->jobDesc == 'Admin'){
            $guard = 'admin';
        }else if($role->jobDesc == 'Cashier' || $role->jobDesc == 'Courrier' || $role->jobDesc == 'Chef'){
            $guard = 'staff';
        }

        if(Auth::guard($guard)->attempt($creds)){
            return redirect()->route($guard.'.home');
        }else{
            return redirect()->route('staff.login')->with('Fail','Incorrect credentials');
        }
    }

    function cashier(){
        $cashier = DB::table('transactions')
                    ->join('staff','transactions.cashierStaffID','=','staff.id')
                    ->join('users','transactions.pembeliID','=','users.id')
                    ->where('transactions.cashierStaffID','=',Auth::user()->id)
                    ->select('transactions.id as transactionID','staff.nama as nama','transactions.totalHarga as totalHarga','transactions.status as status','transactions.id as transactionsID')
                    ->get();
        $menu = DB::table('transaction_details')
                    ->join('menus','transaction_details.barangID','=','menus.id')
                    ->join('transactions','transaction_details.transaksiID','=','transactions.id')
                    ->where('transactions.cashierStaffID','=',Auth::user()->id)
                    ->select('menus.namaMenu as namaBarang','transaction_details.jumlahBarang as jumlahBarang','transaction_details.additionalNotes as additionalNotes')
                    ->get();
        return view('dashboard.staff.pages.cashier',['cashier' => $cashier,'menu' => $menu]);
    }

    function cashierApprove($id){
        Transaction::where('id','=',$id)
                ->update([
                    'status' => 'Paid'
                ]);
        return redirect()->back()->with('Success','You have approved one of the transaction!');
    }

    function chef(){
        $chef = DB::table('transactions')
                    ->join('staff','transactions.chefStaffID','=','staff.id')
                    ->join('users','transactions.pembeliID','=','users.id')
                    ->where('transactions.chefStaffID','=',Auth::user()->id)
                    ->Where('status','=','paid')
                    ->select('transactions.id as transactionID','staff.nama as nama','transactions.totalHarga as totalHarga','transactions.status as status','transactions.id as transactionsID')
                    ->get();
        $menu = DB::table('transaction_details')
                    ->join('menus','transaction_details.barangID','=','menus.id')
                    ->join('transactions','transaction_details.transaksiID','=','transactions.id')
                    ->where('transactions.chefStaffID','=',Auth::user()->id)
                    ->select('menus.namaMenu as namaBarang','transaction_details.jumlahBarang as jumlahBarang','transaction_details.additionalNotes as additionalNotes')
                    ->get();
        return view('dashboard.staff.pages.chef',['chef'=>$chef,'menu'=>$menu]);
    }

    function chefApprove($id){
            Transaction::where('id','=',$id)
                ->update([
                    'status' => 'Cooked'
                ]);
        return redirect()->back()->with('Succes','You have approved one of the transaction!');
    }

    function delivery(){
        $delivery = DB::table('transactions')
                ->join('users','transactions.pembeliID','=','users.id')
                ->join('deliveries','transactions.id','=','deliveries.transaksiID')
                ->join('staff','deliveries.deliveryStaffID','=','staff.id')
                ->where('deliveries.deliveryStaffID','=',Auth::user()->id)
                ->select('transactions.id as transactionID','staff.nama as nama','transactions.totalHarga as totalHarga','transactions.status as status','transactions.id as transactionsID','deliveries.alamatPembeli as alamatPembeli')
                ->get();
        $menu = DB::table('transaction_details')
                ->join('menus','transaction_details.barangID','=','menus.id')
                ->join('transactions','transaction_details.transaksiID','=','transactions.id')
                ->join('deliveries','transactions.id','=','deliveries.transaksiID')
                ->where('deliveries.deliveryStaffID','=',Auth::user()->id)
                ->select('menus.namaMenu as namaBarang','transaction_details.jumlahBarang as jumlahBarang','transaction_details.additionalNotes as additionalNotes')
                ->get();
        return view('dashboard.staff.pages.delivery',['delivery' => $delivery, 'menu' => $menu]);
    }

    function deliveryAprove($id){
        Transaction::where('id','=',$id)
            ->update([
                'status' => 'Delivered'
            ]);
    return redirect()->back()->with('Succes','You have approved one of the transaction!');
}

    function logout(){
        Auth::guard('staff')->logout();
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
