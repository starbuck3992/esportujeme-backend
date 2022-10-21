<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProviderController extends Controller
{
    public function list()
    {

        $user = User::find(Auth::id());

        return ProviderResource::collection($user->providers()->get());

    }
}
