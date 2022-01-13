<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    function cart(){
        $cart = DB::table('transactions')
                    ->join('transaction_details','transactions.id','=','transaction_details.transaksiID')
                    ->join('menus','menus.id','=','transaction_details.barangID')
                    ->where('pembeliID','=',Auth::user()->id)
                    ->select('menus.namaMenu as namaMenu', 'menus.linkGambar as linkGambar', 'transaction_details.jumlahBarang as jumlahBarang', 'menus.hargaJual as hargaJual', 'transaction_details.id as tdid', 'transactions.totalHarga as totalHarga')
                    ->get();
        return view('dashboard.user.cart',['cart'=>$cart]);
    }

    function addtocart($id){
        $menu = Menu::where('id',$id)->first();
        $staff = Staff::count();
        $rand = rand(1,$staff);
        $staff = Staff::where('id','=',$rand)->first();
        $check = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();

        // If there's no datas in Transaction Detail or brand new transaction
        if(!$check){

            Transaction::create([
                'pembeliID' => Auth::user()->id,
                'staffID' => $staff->id,
                'totalHarga' => $menu->hargaJual,
                'status' => 'unpaid',
            ]);

            $transaction = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();

            TransactionDetail::create([
                'transaksiID' => $transaction->id,
                'barangID' => $menu->id,
                'jumlahBarang' => 1,
                'totalHarga' => $menu->hargaJual,
                'additionalNotes' => 's',
            ]);
    
        }else if($check){

            $transaction = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();
            $transactionDetail = TransactionDetail::where('transaksiID','=',$transaction->id)->first();
            
            $check = TransactionDetail::where('transaksiID','=',$transaction->id)->where('barangID','=',$id)->first();

            // If new data match with previous data
            if($transaction && $check){
                $menu = Menu::where('id','=',$transactionDetail->barangID)->first();
                TransactionDetail::where('id',$transactionDetail->id)
                    ->update([
                        'jumlahBarang' => 3,
                        'totalHarga' => 3 * $menu->hargaJual
                    ]);

                Transaction::where('id',$transactionDetail->transaksiID)
                    ->update([
                        'totalHarga' => 3 * $menu->hargaJual
                    ]);

            } // If new data doesn't match with previous data
            else if($transaction && $check == NULL){
                $menu = Menu::where('id','=',$id)->first();

                TransactionDetail::create([
                    'transaksiID' => $transactionDetail->transaksiID,
                    'barangID' => $menu->id,
                    'jumlahBarang' => 1,
                    'totalHarga' => $menu->hargaJual,
                    'additionalNotes' => 'a',
                ]);
    
                Transaction::where('id',$transactionDetail->transaksiID)
                        ->update([
                            'totalHarga' => $transaction->totalHarga + $menu->hargaJual,
                ]);
            }

        }

        return redirect()->back()->with('Success','Your Item has been Added to the Cart!');

    }

    function remove_cartitem($id){

        $check = TransactionDetail::where('id','=',$id)->first();
        $menu = Menu::where('id','=',$check->barangID)->first();

        if($check->jumlahBarang > 1){

            $transaction = Transaction::where('id','=',$check->transaksiID)->first();

            TransactionDetail::where('id','=',$id)
                ->update([
                    'jumlahBarang' => $check->jumlahBarang - 1
                ]);
            Transaction::where('id','=',$check->transaksiID)
                ->update([
                    'totalHarga' => $transaction->totalHarga - $menu->hargaJual
                ]);

        }else if($check->jumlahBarang == 1){

            $delete1 = TransactionDetail::where('id','=',$id)->get();
            $delete2 = Transaction::where('id','=',$check->transaksiID)->get();
            $delete1->each->delete();
            $delete2->each->delete(); 

        }

        return redirect('user/home')->with('Success','Your Item has been Deleted');
    }

}
