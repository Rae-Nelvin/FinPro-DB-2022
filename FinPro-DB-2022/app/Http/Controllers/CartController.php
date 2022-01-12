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
        $totalHarga = 1 * $menu->hargaJual;

        // If there's no datas in Transaction Detail or brand new transaction
        if(!$check){

            Transaction::create([
                'pembeliID' => Auth::user()->id,
                'staffID' => $staff->id,
                'totalHarga' => $totalHarga,
                'status' => 'unpaid',
            ]);

            $transaction = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();

            TransactionDetail::create([
                'transaksiID' => $transaction->id,
                'barangID' => $menu->id,
                'jumlahBarang' => 1,
                'totalHarga' => $totalHarga,
                'additionalNotes' => 's',
            ]);
    
        }else if ($check){

            $check = TransactionDetail::where('barangID',$id)->first();

            // If new data match with previous data
            if($check){
                TransactionDetail::where('id',$check->id)
                    ->update([
                        'jumlahBarang' => 2,
                        'totalHarga' => 2 * $totalHarga
                    ]);

                Transaction::where('id',$check->transaksiID)
                    ->update([
                        'totalHarga' => 2 * $totalHarga
                    ]);

            } // If new data doesn't match with previous data
            else{

                $check = TransactionDetail::where('barangID',$id)->first();

                TransactionDetail::create([
                    'transaksiID' => $check->transaksiID,
                    'barangID' => $menu->id,
                    'jumlahBarang' => 1,
                    'totalHarga' => $totalHarga,
                    'additionalNotes' => 'a',
                ]);
    
                Transaction::where('id',$check->transaksiID)
                        ->update([
                            'totalHarga' => $check->totalHarga + $totalHarga,
                ]);
            }

        }

        return redirect()->back()->with('Success','Your Item has been Added to the Cart!');

    }

    function remove_cartitem($id){

        $check = TransactionDetail::where('id','=',$id)->first();
        $count = TransactionDetail::where('transaksiID','=',$check->transaksiID)->count();

        if($count == 1){

            $delete1 = TransactionDetail::where('id','=',$id)->get();
            $delete2 = Transaction::where('id','=',$check->transaksiID)->get();
            $delete1->each->delete();
            $delete2->each->delete(); 

        }else{
            $delete1 = TransactionDetail::where('id','=',$id)->get();
            $transaction = Transaction::where('id','=',$check->transaksiID)->first();

            if($check->jumlahBarang > 1){

                TransactionDetail::where('id','=',$id)
                    ->update([
                        'jumlahBarang' => $check->jumlahBarang - 1
                    ]);
                Transaction::where('id','=',$check->transaksiID)
                    ->update([
                        'totalHarga' => $transaction->totalHarga - $check->totalHarga
                    ]);

            }else if($check->jumlahBarang == 1){

                Transaction::where('id','=',$check->transaksiID)
                ->update([
                    'totalHarga' => $transaction->totalHarga - $check->totalHarga,
                ]);
                $delete1->each->delete();

            }
        }

        return redirect('user/home')->with('Success','Your Item has been Deleted');
    }

}
