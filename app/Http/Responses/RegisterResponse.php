<?php

namespace App\Http\Responses;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{

    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {

        return new UserResource(Auth::user());

    }
}
