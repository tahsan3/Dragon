<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Image;
use Carbon\Carbon;
use App\Http\Requests\CategoryPost;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admincheck', 'verified']);
    }
    function index(){
        $categories = Category::latest()->get();
        $trashed_categories = Category::onlyTrashed()->get();
        return view('admin.category.index', [
            'categories'=> $categories,
            'trashed_categories'=> $trashed_categories,
        ]);
    }
    function insert(CategoryPost $request){

        // if(Category::withTrashed()->where('category_name', $request->category_name)){
        //     return back()->with('category_exist', 'category already exist');
        // }
        // else{
            $category_id = Category::insertGetId([
                'category_name' => $request->category_name,
                'added_by' => Auth::id(),
                'created_at' => Carbon::now(),
            ]);
            $new_category_photo = $request->category_image;
            $extension = $new_category_photo->getClientOriginalExtension();
            $category_name = $category_id . '.' . $extension;

            Image::make($new_category_photo)->resize(600, 328)->save(base_path('public/uploads/category/' . $category_name));
            Category::find($category_id)->update([
                'category_image' => $category_name,
            ]);

            return back()->with('success', 'Category Added Succssfully');
        // }


    }
    function delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('category_delete', 'Category Deleted Successfully!');
    }
    function edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit', compact('category_info'));
    }

    function update(Request $request){
        Category::find($request->category_id)->update([
            'category_name'=>$request->category_name,
            'added_by'=>Auth::id(),
            'updated_at'=>Carbon::now(),
        ]);
    }

    function restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restore', 'Category Restored!');
    }

    function perdelete($category_id)
    {
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('perdelete', 'Category Deleted Permantly!');
    }

    function mark_delete(Request $request){
        if($request->mark){
            foreach ($request->mark as $mark_id) {
                Category::find($mark_id)->delete();
            }
            return back()->with('mark_del', 'Marked Category Deleted!');
        }
        else{
            return back();
        }
    }
    function category_status($category_id){
        $status = Category::find($category_id)->status;
        if($status == 0){
            $count_status_active = Category::where('status', 1)->count();
            if($count_status_active == 3){
                return back()->with('limit_cross', 'Maximum 3 Category can Active');
            }
            Category::find($category_id)->update([
                'status'=>1,
            ]);
        }
        else{
            Category::find($category_id)->update([
                'status' => 0,
            ]);
        }
        return back();
    }
}
