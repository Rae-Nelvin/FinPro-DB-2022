<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Staff;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    function cart(){
        $cart = DB::table('transactions')
                    ->join('transaction_details','transactions.id','=','transaction_details.transaksiID')
                    ->join('menus','menus.id','=','transaction_details.barangID')
                    ->where('pembeliID','=',Auth::user()->id)
                    ->where('transactions.status','=','unpaid')
                    ->select('menus.namaMenu as namaMenu', 'menus.linkGambar as linkGambar', 'transaction_details.jumlahBarang as jumlahBarang', 'menus.hargaJual as hargaJual', 'transaction_details.id as tdid', 'transactions.totalHarga as totalHarga', 'transaction_details.totalHarga as totalHarga2')
                    ->get();
        $totalHarga = Transaction::where('pembeliID','=',Auth::user()->id)->first();
        return view('dashboard.user.cart',['cart'=>$cart,'totalHarga'=>$totalHarga]);
    }

    function addtocart(Request $request){
        $id = $request->id;
        $menu = Menu::where('id',$id)->first();
        // Validating Requests
        $request->validate([
            'quantity' => 'required|min:1'
        ]);
        $jumlahBarang = $request->quantity;
        $additionalNotes = $request->additionalNotes;
        $cashierStaffID = Staff::inRandomOrder()->where('jobDesc','=','Cashier')->first();
        $chefStaffID = Staff::inRandomOrder()->where('jobDesc','=','Chef')->first();
        $check = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();

        // If there's no datas in Transaction Detail or brand new transaction
        if(!$check){

            Transaction::create([
                'pembeliID' => Auth::user()->id,
                'cashierStaffID' => $cashierStaffID->id,
                'chefStaffID' => $chefStaffID->id,
                'totalHarga' => $menu->hargaJual * $jumlahBarang,
                'status' => 'Unpaid',
            ]);

            $transaction = Transaction::where('status','=','unpaid')->where('pembeliID','=',Auth::user()->id)->first();

            TransactionDetail::create([
                'transaksiID' => $transaction->id,
                'barangID' => $menu->id,
                'jumlahBarang' => $jumlahBarang,
                'totalHarga' => $menu->hargaJual * $jumlahBarang,
                'additionalNotes' => $additionalNotes,
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
                        'jumlahBarang' => $jumlahBarang,
                        'totalHarga' => $jumlahBarang * $menu->hargaJual
                    ]);

                Transaction::where('id',$transactionDetail->transaksiID)
                    ->update([
                        'totalHarga' => $jumlahBarang * $menu->hargaJual
                    ]);

            } // If new data doesn't match with previous data
            else if($transaction && $check == NULL){
                $menu = Menu::where('id','=',$id)->first();

                TransactionDetail::create([
                    'transaksiID' => $transactionDetail->transaksiID,
                    'barangID' => $menu->id,
                    'jumlahBarang' => $jumlahBarang,
                    'totalHarga' => $menu->hargaJual,
                    'additionalNotes' => $additionalNotes,
                ]);
    
                Transaction::where('id',$transactionDetail->transaksiID)
                        ->update([
                            'totalHarga' => $transaction->totalHarga + $menu->hargaJual,
                ]);
            }
        }
        return redirect('user/home')->with('Success','Your Item has been Added to the Cart!');
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

    function checkout(){
        $transaction = DB::table('transactions')
                    ->join('transaction_details','transactions.id','=','transaction_details.transaksiID')
                    ->join('menus','menus.id','=','transaction_details.barangID')
                    ->where('pembeliID','=',Auth::user()->id)
                    ->where('status','=','Unpaid')
                    ->select('menus.namaMenu as namaMenu', 'menus.linkGambar as linkGambar', 'transaction_details.jumlahBarang as jumlahBarang', 'menus.hargaJual as hargaJual', 'transactions.id as tdid', 'transactions.totalHarga as totalHarga', 'transaction_details.totalHarga as totalHarga2')
                    ->get();
        $user = DB::table('users')
                ->where('id','=',Auth::user()->id)
                ->first();
        return view('dashboard.user.checkout',['transaction'=>$transaction,'user'=>$user]);
    }

    function payment(Request $request){
        $deliveryStaffID = Staff::inRandomOrder()->where('jobDesc','=','Courrier')->first();
        if($request->address){
            Delivery::create([
                'transaksiID' => $request->transaksiID,
                'status' => 'Undelivered',
                'alamatPembeli' => $request->address,
                'pembeliID' => $request->pembeliID,
            ]);
            Transaction::where('id','=',$request->transaksiID)
                    ->update([
                        'deliveryStaffID' => $deliveryStaffID->id
                    ]);
        }

        $transaction = DB::table('transactions')
                    ->join('transaction_details','transactions.id','=','transaction_details.transaksiID')
                    ->join('menus','menus.id','=','transaction_details.barangID')
                    ->where('pembeliID','=',Auth::user()->id)
                    ->where('status','=','Unpaid')
                    ->select('menus.namaMenu as namaMenu', 'menus.linkGambar as linkGambar', 'transaction_details.jumlahBarang as jumlahBarang', 'menus.hargaJual as hargaJual', 'transactions.id as tdid', 'transactions.totalHarga as totalHarga', 'transaction_details.totalHarga as totalHarga2')
                    ->get();
        $user = DB::table('users')
                ->where('id','=',Auth::user()->id)
                ->first();

        return view('dashboard.user.payment',['transaction'=>$transaction,'user'=>$user]);
    }

    function checkPayment(Request $request){
        // Validating Inputs
        $request->validate([
            'buktiPembayaran' => 'required'
        ]);

        $pembeliName = User::where('id','=',$request->pembeliID)->first();

        $imageName = $pembeliName->name.'-'.$request->transaksiID.'-'.$request->buktiPembayaran->getClientOriginalName();
        $request->buktiPembayaran->move(public_path('assets/uploads/buktiPembayaran/'), $imageName);

        Transaction::where('id','=',$request->transaksiID)
                ->update([
                    'status' => 'Transferred',
                    'buktiPembayaran' => $imageName
                ]);
        
        return redirect('user/home')->with('Success','Your Payment is being Checked');
    }

}
