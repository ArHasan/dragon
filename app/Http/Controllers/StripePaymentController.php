<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Cart;
use App\order;
use Auth;
use App\Product;
use App\Order_list;
use Carbon\Carbon;


class StripePaymentController extends Controller
{

    public function stripe()
    {
        return view('stripe');
    }

    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Charge::create ([
                "amount" => $request->total * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => " payment from ArHasan"
        ]);

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

        //   Session::flash('success', 'Payment successful!');
          return redirect('/');
        //   return back();

    }
}
