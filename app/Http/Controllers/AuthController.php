<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\LoginResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request) {

        try {

            $user = new User();

            $user->nickname = $request->nickname;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);

            $user->save();

            $user->sendEmailVerificationNotification();

            return response()->json(['message' => 'Úspěšně jsi se registroval']);

        } catch (Throwable $e) {

            report($e);

            return response()->json(['message' => 'Nastala chyba při registraci'], 500);

        }
    }

    public function login(UserLoginRequest $request) {
        try {

        $user = User::where('email', $request->email)->first();

        // Check password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Špatné přihlašovací údaje'], 401);
        }

        $token = $user->createToken(config('app.name'))->plainTextToken;

        return new LoginResource($user, $token);

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Nastala chyba při přihlašování'], 500);

        }
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Úspěšně odhlášen']);
    }
}
