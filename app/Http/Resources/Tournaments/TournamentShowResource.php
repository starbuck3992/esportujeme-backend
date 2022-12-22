<?php

namespace App\Http\Resources\Tournaments;

use App\Http\Resources\CurrencyResource;
use App\Http\Resources\GameResource;
use App\Http\Resources\PlatformResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TournamentShowResource extends JsonResource
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
            'name' => $this->name,
            'information' => $this->information,
            'fee' => $this->fee,
            'scheduleStart' => $this->schedule_start,
            'scheduleEnd' => $this->schedule_end,
            'registeredCount' => $this->registered_count,
            'platform'   => new PlatformResource($this->whenLoaded('platform')),
            'game'   => new GameResource($this->whenLoaded('game')),
            'tournamentType'   => new TournamentTypeResource($this->whenLoaded('tournamentType')),
            'tournamentStatus'   => new TournamentStatusResource($this->whenLoaded('tournamentStatus')),
            'currency'   => new CurrencyResource($this->whenLoaded('currency')),
            'tournamentMatches'   => TournamentMatchResource::collection($this->whenLoaded('tournamentMatches'))
        ];
    }
}
