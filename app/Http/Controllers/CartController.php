<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{


    function addtocart(Request $request){
       Cart::insert([
        'user_id'=>Auth::id(),
        'product_id'=>$request->product_id,
        'color_id'=>$request->color_id,
        'size_id'=>$request->size_id,
        'quantity'=>$request->quantity,
        'created_at'=>Carbon::now(),
       ]);
       return back();
    }

    function cart_delete($cart_id){
        Cart::find($cart_id)->delete();
        return back();
    }

    function cart($coupon_code = ''){

        if($coupon_code == ''){
            $discount = 0;
        }
        else{
            if(Coupon::where('coupon_name', $coupon_code)->exists()){
                if(Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon_code)->first()->validity){
                    return back()->with('expired', 'Coupon Code Expired');
                }
                else{
                    $discount = Coupon::where('coupon_name', $coupon_code)->first()->discount;
                }
            }
            else{
                return back()->with('invalid', 'Invalid Coupon Code');
            }
        }

        $carts = Cart::where('user_id', Auth::id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'discount'=> $discount,
            'coupon_code'=> $coupon_code,
        ]);
    }

    function cartupdate(Request $request){
        foreach($request->qtybutton as $index_urufe_card_id => $cart_quantity){
            Cart::find($index_urufe_card_id)->update([
                'quantity'=> $cart_quantity,
            ]);
        }
        return back();
    }
    function cart_clear(){
        Cart::where('user_id', Auth::id())->delete();
        return back();
    }

}
