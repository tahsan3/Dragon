<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Country;
use  App\Models\Order;
use  App\Models\Cart;
use App\Models\Inventory;
use App\Models\Order_billing_details;
use App\Models\Order_product_details;
use Carbon\Carbon;
use Auth;
use Mail;
use App\Mail\Sendinvoice;


class CheckoutController extends Controller
{
    function getCityList(Request $request){
        $cities = City::where('country_id', $request->country_id)->select('id','name')->get();
        $str_to_send = "<option>-- Select City --</option>";

        foreach($cities as $city){
            $str_to_send .= '<option value="'.$city->id.'">'.$city->name.'</option>';
        }
        echo $str_to_send;
    }

    function order_insert(Request $request){
        $request->validate([
            'payment_method'=>'required',
        ]);


        // Orders insert
        $order_id = Order::insertGetId([
            'user_id'=>Auth::id(),
            'sub_total'=> $request->product_total,
            'grand_total'=> $request->total + $request->delivery_charge,
            'discount'=> $request->discount,
            'delivery_charge'=> $request->delivery_charge,
            'payment_method'=> $request->payment_method,
            'created_at'=> Carbon::now(),
        ]);

         Order_billing_details::insert([
            'order_id'=> $order_id,
            'name'=> $request->name,
            'email'=> $request->email,
            'phone'=>$request->phone,
            'zip'=>$request->zip,
            'country_id'=>$request->country_id,
            'city_id'=>$request->city_id,
            'address'=>$request->address,
            'notes'=>$request->notes,
            'created_at' => Carbon::now(),
        ]);


        $cart_items = Cart::where('user_id', Auth::id())->get();
        foreach($cart_items as $cart){

            Order_product_details::insert([
                'order_id'=> $order_id,
                'user_id'=> Auth::id(),
                'product_id'=>$cart->product_id,
                'product_name'=>$cart->relation_to_products->product_name,
                'product_price'=>$cart->relation_to_products->discount_price,
                'quantity'=>$cart->quantity,
                'created_at' => Carbon::now(),
            ]);
        }

        if($request->payment_method == 1){
            foreach($cart_items as $cart){
                Inventory::where('product_id',$cart->product_id)->where('color_id', $cart->color_id)->where('size_id', $cart->size_id)->decrement('quantity', $cart->quantity);
            }
            //send invoice
            $order_info = Order::where('id', $order_id)->get();
            Mail::to(Auth::user()->email)->send(new Sendinvoice($order_info));

            //send sms
            $url = "http://66.45.237.70/api.php";
            $number = Order_billing_details::where('order_id', $order_id)->first()->phone;
            $text = "Thanks For Purchasing Our Products";
            $data = array(
                'username' => "huzaifaahmed",
                'password' => "NZRACKXY",
                'number' => "$number",
                'message' => "$text"
            );

            $ch = curl_init(); // Initialize cURL
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $smsresult = curl_exec($ch);
            $p = explode("|", $smsresult);
            $sendstatus = $p[0];

            //card delete
            Cart::where('user_id', Auth::id())->delete();
            return redirect('/order/confirmed');
        }
        elseif ($request->payment_method == 2) {
            return redirect('/sslcommerz');
        }

        else{
            return redirect('/stripe');
        }


        return back();

    }

 function order_confirm(){
     return view('frontend.confirm');
 }

}
