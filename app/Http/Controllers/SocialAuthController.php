<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    //Generate redirect URL
    public function redirect($provider)
    {

        $url = Socialite::driver($provider)->stateless()->redirect();

        return response()->json([
            'url' => $url
        ]);

    }

    //Login user
    public function login($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        //Link social account
        if (Auth::check()) {
            User::find(Auth::id())->providers()
                ->firstOrCreate([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId()
                ],
                    ['avatar' => $socialUser->getAvatar()]);

            return response()->json([
                'message' => 'Účet byl připojen'
            ]);
        }

        //Social account exists?
        $user = User::query()
            ->whereHas('providers', function (Builder $query) use ($provider, $socialUser) {
                $query->where([
                    ['provider', $provider],
                    ['provider_id', $socialUser->getId()],
                ]);
            })
            ->first();

        //Login
        if ($user) {

            Auth::login($user, true);

            return (new UserResource($user));

        }

        //Email exists?
        if (User::firstWhere('email', $socialUser->getEmail())) {

            return response()->json(['message' => 'Uživatel s daným emailem již existuje'], 422);

        }

        //Create user
        $userCreated = User::create([
            'nick' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'image_id' => 1
        ]);

        //Create provider
        $userCreated->providers()
            ->create([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar()
            ]);

        Auth::login($userCreated, true);

        return (new UserResource($userCreated));
    }
}
