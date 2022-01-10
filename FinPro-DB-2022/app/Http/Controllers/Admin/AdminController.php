<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    function uploadmenu(Request $request){
        // Validating Requests
        $request->validate([
            'title' => 'required',
            'picture' => 'required',
            'recipee' => 'required',
            'quantity' => 'required|min:1|max:1000'
        ]);

        dd($request->recipee);
    }

    function uploadstaff(Request $request){
        // Validating Requests
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6|max:15',
            'pnumber' => 'required|min:12|max:16',
            'jobdesc' => 'required'
        ]);

    //     $staff = new Staff();
    //     Staff::create([
    //         'nama' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),

    //     ]);
    //     $staff->name = $request->name;
    //     $staff->email = $request->email;
    //     $staff->password = \Hash::make($request->password);
    //     $staff->phone = $request->pnumber;
    //     $staff->jobDesc = $request->jobDesc;
    //     $staff->linkGambar = $request->picture;
    //     $save = $staff->save();

    //     if ($save){
    //         return redirect('admin.dashboard.staff')->with('Success','Your New Staff has been Uploaded');
    //     }else{
    //         return redirect()->back()->with('Fail','The data has failed to be Uploaded');
    //     }
    // }
}
