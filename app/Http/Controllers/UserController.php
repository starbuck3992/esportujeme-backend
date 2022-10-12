<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserController extends Controller
{
    public function show($id)
    {
        try {
            return new UserResource(User::where('id', $id)->where('id',Auth::id())->firstorfail());

        } catch (Throwable $e) {

            report($e);
            return response()->json(['message' => 'Uživatel nenalezen'], 404);

        }
    }
}
