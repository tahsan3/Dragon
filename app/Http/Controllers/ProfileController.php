<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

use App\Models\User;
use Auth;
use Image;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    function index(){
        return view('admin.profile.index');
    }
    function nameupdate(Request $request){
        User::find(Auth::id())->update([
            'name'=> $request->name,
        ]);
        return back()->with('name_update', 'Name Updated!');
    }
    function passupdate(Request $request){
        $request->validate([
            'old_password'=> 'required',
            'password'=> 'required|confirmed',
            'password'=> Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ]);
        if(Hash::check($request->old_password, Auth::user()->password)){
            User::find(Auth::id())->update([
                'password'=>bcrypt($request->password),
            ]);
        }
        else{
            return back()->with('old_password', 'Old Password Does Not Match!');
        }
        return back();
    }
    function photoupdate(Request $request){
        $request->validate([
            'photo'=>'image',
            'photo'=>'mimes:jpg,png,jpeg,gif',
            'photo'=> 'file|max:512',
        ]);

        $new_profile_photo = $request->photo;
        $extension = $new_profile_photo->getClientOriginalExtension();
        $photo_name = Auth::id().'.'.$extension;

        if(Auth::user()->photo != 'default.jpg'){
            $path = public_path()."/uploads/user/".Auth::user()->photo;
            unlink($path);
        }

        Image::make($new_profile_photo)->save(base_path('public/uploads/user/'.$photo_name));
        User::find(Auth::id())->update([
            'photo'=> $photo_name,
        ]);
        return  back();

    }
}
