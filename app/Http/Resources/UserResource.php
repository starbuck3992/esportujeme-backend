<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
                'nickname' => $this->nickname,
                'suffix' => $this->suffix,
                'avatar' => $this->avatar,
                'about' => $this->about,
                'name' => $this->name,
                'surname' => $this->surname,
                'email' => $this->email,
                'playstationProfile' => $this->playstation_profile,
                'xboxProfile' => $this->xbox_profile,
        ];
    }
}
