<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json(['message' => 'Nevalidní link'], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->to('/');
    }

    public function resend() {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email již byl ověřen'], 400);
        }

        auth()->user()->sendEmailVerificationNotification();

        return response()->json(['message' => 'Ověřovací email byl odeslán']);
    }
}
