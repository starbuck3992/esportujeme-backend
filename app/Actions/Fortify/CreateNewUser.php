<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'nickname' => ['required', 'string', 'max:32'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        //Suffix
        $nicknameCount = User::where('nickname', $input['nickname'])->count();
        $suffixNumber = sprintf('#%04d', $nicknameCount + 2);

        return User::create([
            'nickname' => $input['nickname'],
            'suffix' => $suffixNumber,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
