<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    function menu(){
        $menu = Menu::get();
        return view('dashboard.admin.menu', ['menu'=>$menu]);
    }

    function upload_menu(Request $request){
        // Validating Requests
        $request->validate([
            'name' => 'required',
            'picture' => 'required',
            'description' => 'required',
            'quantity' => 'required|min:1|max:1000',
            'hargaJual' => 'required|min:1',
            'hargaBeli' => 'required|min:1'
        ]);

        $imageName = $request->name.'-'.$request->picture->getClientOriginalName();
        $request->picture->move(public_path('assets/menus/'), $imageName);

        Menu::create([
            'namaMenu' => $request->name,
            'deskripsiMenu' => $request->description,
            'jumlahBarang' => $request->quantity,
            'hargaJual' => $request->hargaJual,
            'hargaBeli' => $request->hargaBeli,
            'linkGambar' => $imageName
        ]);

        return redirect('admin/menu')->with('Success','Your New Menu has been Uploaded');
    }

    function editmenu($id){
        $menu = Menu::where('id','=',$id)->get();
        return view('dashboard.admin.uploads.editmenu',['menu'=>$menu]);
    }

    function edit_menu(Request $request){
        // Validating Requests
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'picture' => 'required',
            'quantity' => 'required|min:1|max:1000',
            'hargaJual' => 'required|min:1',
            'hargaBeli' => 'required|min:1'
        ]);

        $imageName = $request->name.'-'.$request->picture->getClientOriginalName();
        $request->picture->move(public_path('assets/menus/'), $imageName);

        Menu::where('id',$request->id)
            ->update([
                'namaMenu' => $request->name,
                'deskripsiMenu' => $request->description,
                'jumlahBarang' => $request->quantity,
                'hargaJual' => $request->hargaJual,
                'hargaBeli' => $request->hargaBeli,
                'linkGambar' => $imageName
            ]);

        return redirect('admin/menu')->with('Success','Your Staff has been Edited');
    }

    function delete_menu($id){
        $menu = Menu::where('id',$id)->get();
        $menu->each->delete();
        return redirect('admin/menu')->with('Success', 'Your Menu has been Deleted');
    }

    function staff(){
        $staff = Staff::where('jobDesc','!=','Admin')->get();
        return view('dashboard.admin.staff', ['staff'=>$staff]);
    }

    function upload_staff(Request $request){
        // Validating Requests
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:6|max:15',
            'gender' => 'required',
            'pnumber' => 'required|min:12|max:16',
            'jobDesc' => 'required'
        ]);

        if($request->picture){
            $imageName = $request->name.'/'.$request->picture->getClientOriginalName();
            $request->picture->move(public_path('assets/staff/'.$request->name), $imageName);
        }else{
            $imageName = '';
        }

        Staff::create([
            'nama' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'gender' => $request->gender,
            'phone' => $request->pnumber,
            'jobDesc' => $request->jobDesc,
            'linkGambar' => $imageName
        ]);

        return redirect('admin/staff')->with('Success','Your New Staff has been Uploaded');
    }

    function editstaff($id){
        $staff = Staff::where('id','=',$id)->get();
        return view('dashboard.admin.uploads.editstaff',['staff'=>$staff]);
    }

    function edit_staff(Request $request){
        // Validating inputs
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|exists:staff,email',
            'password' => 'required|min:6|max:15',
            'gender' => 'required',
            'pnumber' => 'required|min:12|max:16',
            'jobDesc' => 'required'
        ]);

        if($request->picture){
            $imageName = $request->name.'/'.$request->picture->getClientOriginalName();
            $request->picture->move(public_path('assets/staff/'.$request->name), $imageName);
        }else{
            $imageName = '';
        }

        Staff::where('id',$request->id)
            ->update([
                'nama' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'phone' => $request->pnumber,
                'jobDesc' => $request->jobDesc,
                'linkGambar' => $imageName
            ]);

        return redirect('admin/staff')->with('Success','Your Staff has been Edited');
    }

    function delete_staff($id){
        $staff = Staff::where('id',$id)->get();
        $staff->each->delete();
        return redirect('admin/staff')->with('Success', 'Your Staff has been Deleted');
    }
}
