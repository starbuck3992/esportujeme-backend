<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TournamentCreateRequest extends FormRequest
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
            'name' => ['required', 'max:64', Rule::unique('tournaments')],
            'platform' => 'required|integer',
            'game' => 'required|integer',
            'tournamentType' => 'required|integer',
            'maxPlayers' => 'required|integer',
            'currency' => 'required|integer',
            'information' => 'required|max:512',
            'fee' => 'required|integer',
            'scheduleStart' => 'required|date'
        ];
    }
}
