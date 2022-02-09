<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    function inventory($product_id)
    {
        $product_name = Product::find($product_id)->product_name;
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.product.addinventory',[
            'product_name'=> $product_name,
            'colors'=> $colors,
            'sizes'=> $sizes,
            'product_id'=> $product_id,
            'inventories'=> $inventories,
        ]);
    }

    function inventory_insert(Request $request){
        if(
            Inventory::where([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
            ])->exists()
        ){
            Inventory::where([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
            ])->increment('quantity', $request->quantity);
        }
        else{
            Inventory::insert([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
                'quantity' => $request->quantity,
                'created_at' => Carbon::now(),
            ]);
        }

        return back();
    }

}
