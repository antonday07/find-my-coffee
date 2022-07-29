<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthenticationController extends Controller
{
   public function getSocialRedirect($social)
   {
        try{
            return Socialite::with( $social )->redirect();
        }catch ( \InvalidArgumentException $e ){
            return redirect('/login');
        }
   }

   public function getSocialCallback($social)
   {
        /*
            Grabs the user who authenticated via social account.
        */
        $socialUser = Socialite::with( $social )->user();

        $user = User::where('provider_id', $socialUser->id)
                    ->where('provider', $social)
                    ->first();
     
        if( empty($user) ) {
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail() == '' ? '' : $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
                'password' => '',
                'provider' => $social,
                'provider_id' => $socialUser->getId()
            ]);
        }

        Auth::login( $user );

        return redirect('/');
       
   }

}
