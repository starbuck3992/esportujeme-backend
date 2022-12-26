<?php

namespace App\Http\Resources\Tournaments\Admin;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TournamentPlayerResource extends JsonResource
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
            'nick' => $this->nick,
            'email' => $this->email,
            'playstationProfile' => $this->playstation_profile,
            'xboxProfile' => $this->xbox_profile,
        ];
    }
}
