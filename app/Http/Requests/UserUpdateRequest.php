<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => ['required', 'max:32'],
            'about' => 'string|max:255',
            'avatar' => 'string|nullable',
            'name' => 'string|max:64|nullable',
            'surname' => 'string|max:64|nullable',
            'playstationProfile' => 'string|max:64|nullable',
            'xboxProfile' => 'string|max:64|nullable'
        ];
    }
}
