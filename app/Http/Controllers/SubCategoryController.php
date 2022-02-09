<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Auth;
use Carbon\Carbon;

class SubCategoryController extends Controller
{
    function index(){
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.subcategory.index', compact('categories', 'subcategories'));
    }
    function insert(Request $request){

        if(SubCategory::where('category_id', $request->category_id)->where('subcategory_name',  $request->subcategory_name)->exists()){
            return back()->with('exist_subcategory', 'Subcategory Already Exist');
        }
        else{

            $request->validate([
                'category_id'=>'required',
                'subcategory_name'=>'required',
            ]);

            Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'added_by'=>Auth::id(),
            'created_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'Subcategory Added!');
        }
    }

    function delete($subcategory_id){
        SubCategory::find($subcategory_id)->delete();
        return back()->with('delete_subcat', 'Subcategory Deleted!');
    }

    function edit($subcategory_id){
        $categories = Category::all();
        $subcategories = SubCategory::find($subcategory_id);
        return view('admin.subcategory.edit', compact('subcategories', 'categories'));
    }

    function update(Request $request){
        SubCategory::find($request->subcategory_id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'added_by'=>Auth::id(),
            'updated_at'=>Carbon::now(),
        ]);
        return back()->with('updated', 'Subcategory Updated');
    }

}
