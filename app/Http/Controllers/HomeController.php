<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admincheck']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       $logged_user_id = Auth::id();
       $users = User::where('id', '!=', $logged_user_id)->orderBy('id', 'desc')->Paginate(2);
       $logged_user = Auth::user()->name;
       $total_user = User::count();
       return view('home', compact('users', 'logged_user', 'total_user'));
    }

    function about(){
        return view('about');
    }
    function contact(){
        return view('contact');
    }
}
