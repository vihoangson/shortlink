<?php

namespace App\Http\Controllers\Socialite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * @return Response
     */
    public function handleProviderCallback($driver)
    {

        try {
            $user = Socialite::driver($driver)->user();
            $finduser = User::where('email', $user->getEmail())->first();
            if ($finduser) {
                auth()->login($finduser, true);
                return redirect('/');
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => '1234',
                    'provider_id' => $user->id,
                    'provider_name' => $driver,
                    'email_verified_at' => now(),
                ]);
                auth()->login($newUser, true);
                return redirect('/home');
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }
}
