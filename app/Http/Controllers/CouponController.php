<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    function coupon(){
        $coupons = Coupon::all();
        return view('admin.coupon.index', [
            'coupons'=> $coupons,
        ]);
    }
    function coupon_insert(Request $request){
        Coupon::create($request->except('_token')+[
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('success', 'Coupon Added!');
    }
}
