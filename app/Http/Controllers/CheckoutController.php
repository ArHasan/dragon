<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Cart;
use App\order;
use App\Product;
use App\Order_list;
use Carbon\Carbon;


class CheckoutController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function Checkout(Request $request){
        if(Auth::user()->role ==1){
            echo 'You are a admin, YOU Cannot Bay';
        }
        else{
            return view('admin.checkout',[
                'carts'=>Cart::where('ip_address',request()->ip())->get(),
                'total'=>$request->total
            ]);
        }
    }

    function CheckoutPost(Request $request){
        if($request->payment_option == 2){
              //insert into order table
      $order_id =  order::insertGetId([
        'user_id' =>Auth::id(),
        'full_name'=>$request->full_name,
        "email" =>$request->email,
        "phone_number" =>$request->phone_number,
        "country" =>$request->country,
        "address" =>$request->address,
        "post_code" =>$request->post_code,
        "city" =>$request->city,
        "notes"=>$request->notes,
        "payment_option"=>$request->payment_option,
        "sub_total"=>$request->sub_total,
        "total"=>$request->total,
        "created_at" => Carbon::now(),
        ]);

        //insert into order_list table
        foreach(Cart::where('ip_address',request()->ip())->get() as $cart){

            Order_list::insert([
                'order_id'=> $order_id,
                'user_id'=> Auth::id(),
                'product_id'=>$cart->product_id,
                'quantity'=> $cart->quantity,
                "created_at" => Carbon::now(),
            ]);
            //decrement form product table
            Product::find($cart->product_id)->decrement('product_quantity',$cart->quantity);
            //deleting form cart table
            Cart::find($cart->id)->delete();
        }
       return redirect('/');
        }
        else{
            return view('stripe',[
                'request_all_data' =>$request->all(),
            ]);

            // return redirect('stripe')->with('total',$request->total);
        }

    }
}
