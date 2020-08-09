<?php

namespace App\Http\Controllers;

use App\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    function AddCoupon(){
        return view('admin.coupon',[
            'coupons'=>Coupon::all(),
        ]);
    }

    function AddCouponPost(Request $request){
        $request->validate([
            'coupon_name'=>'required|unique:coupons,coupon_name',
            'discount_amount'=>'required|numeric|min:1|max:99',
            'validity_date'=>'required',
        ]);
        Coupon::insert([
            'coupon_name'=> strtoupper($request->coupon_name),
            'discount_amount'=> $request->discount_amount,
            'validity_date'=> $request->validity_date,
            'created_at'=> Carbon::now(),
        ]);
        return back();
    }
}
