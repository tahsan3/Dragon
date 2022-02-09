<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GithubController extends Controller
{
    function github_redirect(){
        return Socialite::driver('github')->redirect();
    }
    function github_callback(){
        $user = Socialite::driver('github')->user();

        if(User::where('email', $user->getEmail())->exists()){
            if (Auth::attempt(['email' => $user->getEmail(), 'password' => 'abc@1234'])) {
                return redirect('/');
            }
        }
        else{
            User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'role' => 0,
                'email_verified_at' => Carbon::now(),
                'password' => bcrypt('abc@1234'),
            ]);

            if (Auth::attempt(['email' => $user->getEmail(), 'password' => 'abc@1234'])) {
                return redirect('/');
            }
        }
    }
}
