<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Carbon\Carbon;

class CartController extends Controller
{
    function AddToCart(Request $request){
        if(Cart::where('product_id',$request->product_id)->where('ip_address',$request->ip())->exists()){
            Cart::where('product_id',$request->product_id)->where('ip_address',$request->ip())->increment('quantity',$request->quantity);
        }
        else{
            Cart::insert([
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'ip_address'=>request()->ip(),
                'created_at'=>Carbon::now(),
            ]);
        }
        return back();
    }

    function Cart(){
        return view('admin.cart',[
            'carts'=>Cart::where('ip_address',request()->ip())->get(),
        ]);
    }
}
