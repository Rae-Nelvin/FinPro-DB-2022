<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Staff;
use Illuminate\Support\Facades\Auth;

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
}
