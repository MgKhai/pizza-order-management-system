<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    // redirect social login
    public function redirect($provider){
        return Socialite::driver($provider)->redirect();
    }

    // callback social login
    public function callback($provider){
        $socialLoginData = Socialite::driver($provider)->user();

        $user = User::updateOrCreate([
            'provider_id' => $socialLoginData->id,
        ], [
            'name' => $socialLoginData->name,
            'nickname'=>$socialLoginData->nickname,
            'email' => $socialLoginData->email,
            'provider' => $provider,
            'provider_id' => $socialLoginData->id,
            'provider_token' => $socialLoginData->token,
        ]);

        Auth::login($user);

        // return redirect('/dashboard');
        return to_route('user#home');
    }
}
