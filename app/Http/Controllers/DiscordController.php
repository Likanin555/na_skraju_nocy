<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class DiscordController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function handleProviderCallback()
    {
        $discordUser = Socialite::driver('discord')->user();

        $user = User::updateOrCreate([
            'email' => $discordUser->email,
        ], [
            'name' => $discordUser->name,
            'email' => $discordUser->email,
            'provider' => 'discord',
            'avatar' => $discordUser->avatar
        ]);

        //print_r($discordUser->avatar);
        Auth::login($user);

        return redirect('/');
    }
}
