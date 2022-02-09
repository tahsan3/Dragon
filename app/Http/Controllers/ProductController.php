<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use App\Models\ProductThumbnailMultiple;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Image;
use Str;

class ProductController extends Controller
{
    function index(){
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        return view('admin.product.add_product', [
            'categories'=>$categories,
            'sub_categories'=>$sub_categories,
        ]);
    }

    function addcolor(){
        $colors = Color::all();
        return view('admin.product.color', [
            'colors'=>$colors,
        ]);
    }
    function colorinsert(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function addsize(){
        $sizes = Size::all();
        return view('admin.product.size', [
            'sizes'=> $sizes,
        ]);
    }
    function sizeinsert(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }


    function insert(Request $request){

        $product_code =  Str::random(2).'-'.rand(0,50000).Str::random(2);
        $discount = ($request->product_price / 100) * $request->discount_percentage;
        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_code'=> $product_code,
            'product_name'=>$request->product_name,
            'product_price'=>$request->product_price,
            'discount_percentage'=>$request->discount_percentage,
            'discount_price'=>$request->product_price - $discount,
            'product_desp'=>$request->product_desp,
            'created_at'=>Carbon::now(),
        ]);

        $new_product_photo = $request->product_thumbnail;
        $extension = $new_product_photo->getClientOriginalExtension();
        $product_name = $product_id. '.' . $extension;

        Image::make($new_product_photo)->resize(800,800)->save(base_path('public/uploads/product/'.$product_name));
        Product::find($product_id)->update([
            'product_thumbnail' =>$product_name,
        ]);

        $start = 1;
        foreach($request->product_multiple as $single_image){
            $new_image_name = $product_id.'-'.$start.'.'.$single_image->getClientOriginalExtension();
            Image::make($single_image)->resize(800,800)->save(base_path('public/uploads/product/product_images/'.$new_image_name));
            ProductThumbnailMultiple::insert([
                'product_id'=>$product_id,
                'product_multiple_image'=>$new_image_name,
                'created_at'=>Carbon::now(),
            ]);
            $start++;
        }




        return back()->with('product_added', 'Product Added Successfully');

    }
    function allproduct(){
        $all_products = Product::latest()->Paginate(5);
        return view('admin.product.allproduct', [
            'all_products'=> $all_products,
        ]);
    }
}
