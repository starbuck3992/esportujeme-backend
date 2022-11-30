<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserController extends Controller
{
    public function show(Request $request)
    {
        try {

            return new UserResource(User::where('id', $request->user()->id)->with('providers')->firstorfail());

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Uživatel nenalezen'], 404);
        }
    }

    public function update(UserUpdateRequest $request)
    {
        try {

            $user = User::find(Auth::id());

            $user->nickname = $request->nickname;
            $user->about = $request->about;
            $user->avatar = $request->avatar;
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->playstation_profile = $request->playstationProfile;
            $user->xbox_profile = $request->xboxProfile;
            $user->save();

            return response()->json(['message' => 'Úspěšně uloženo']);

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Nastala chyba při ukládání změn'], 500);

        }
    }
}
