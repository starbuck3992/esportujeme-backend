<?php

namespace App\Http\Resources\Tournaments;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentMatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'bracketPosition' => $this->bracket_position,
            'scoreHome' => $this->score_home,
            'scoreGuest' => $this->score_guest,
            'userHome' => new TournamentPlayerResource($this->whenLoaded('userHome')),
            'userGuest' => new TournamentPlayerResource($this->whenLoaded('userGuest'))
        ];
    }
}
