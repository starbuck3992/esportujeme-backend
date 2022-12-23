<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TournamentSaveScoreRequest extends FormRequest
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
            'bracketPosition' => 'required|integer',
            'scoreHome' => 'integer',
            'scoreGuest' => 'integer',
            'screenshot' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'confirmed' => 'required|boolean',
        ];
    }
}
