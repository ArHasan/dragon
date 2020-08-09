<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Customer_registerController extends Controller
{
    function Customer(){
        return view('admin.customer_register');
    }

    function CustomerPost(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=> 2,
            'created_at'=> Carbon::now(),
      ]);
      return redirect('login');

    }
}
