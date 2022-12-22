<?php

namespace App\Http\Resources\Tournaments;

use Illuminate\Http\Resources\Json\JsonResource;

class TournamentTypeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'maxPlayers' => $this->max_players
        ];
    }
}
