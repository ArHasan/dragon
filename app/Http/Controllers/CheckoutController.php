<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;


class CheckoutController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function Checkout(){
        if(Auth::user()->role ==1){
            echo 'You are a admin, YOU Cannot Bay';
        }
        else{
            return view('admin.checkout',[
                'carts'=>Cart::where('ip_address',request()->ip())->get()
            ]);
        }
    }
}
