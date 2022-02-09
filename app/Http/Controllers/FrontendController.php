<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Size;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Order_product_details;
use Auth;

class FrontendController extends Controller
{
   function welcome(){
       $categories = Category::all();
       $categories_active = Category::where('status',1)->get();
       $products = Product::all();
       return view('frontend.index', [
            'categories'=> $categories,
            'products'=> $products,
            'categories_active'=> $categories_active,
       ]);
   }

   function product_detail($product_id){
        $product_singles = Product::find($product_id);
        $available_colors = Inventory::where('product_id', $product_id)->groupBy('color_id')->selectRaw('count(*) as total, color_id')->get();
        return view('frontend.product_detail', [
            'product_singles'=> $product_singles,
            'available_colors'=> $available_colors,
        ]);
   }

   function getsize(Request $request){
        $sizes = Inventory::where([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
        ])->get(['size_id', 'quantity']);

        $str_to_send = '<option value="">--Select Size--</option>';
        foreach($sizes as $size){
            $size_name = Size::find($size->size_id)->size_name;
            $str_to_send .= '<option value="'.$size->size_id.'">'.$size_name.'</option>';
        }
        echo $str_to_send;
   }

   function getquantity(Request $request){

        $quantity = Inventory::where([
            'size_id'=>$request->size_id,
            'color_id'=>$request->color_id,
        ])->first(['quantity']);
        return $quantity->quantity;
   }

   function checkout(Request $request){
       $discount = $request->discount;
       $delivery = $request->delivery;
       $grand_total = $request->grand_amount;
       $countries = Country::select('id', 'name')->get();
       $carts = Cart::where('user_id', Auth::id())->get();

       return view('frontend.checkout',[
            'countries'=> $countries,
            'carts'=> $carts,
            'discount'=> $discount,
            'delivery'=> $delivery,
            'grand_total'=> $grand_total,
       ]);
   }

   function err_404(){
       return view('404');
   }

   function myaccount(){
       $user_info = Auth::user();
       $my_orders = Order::where('user_id', Auth::id())->get();
       return view('frontend.myaccount', [
           'user_info'=>$user_info,
            'my_orders'=>$my_orders,
       ]);
   }


   function review(Request $request){
        Order_product_details::where('user_id', Auth::id())->where('product_id', $request->product_id)->update([
            'review'=>$request->review,
            'star'=>$request->rating,
        ]);
        return back()->with('review', 'you have successfuly reviewed this product');
   }

}
