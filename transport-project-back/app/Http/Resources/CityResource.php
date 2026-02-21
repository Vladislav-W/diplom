<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'city_id' => $this->city_id,
            'id' => $this->city_id,
            'name' => $this->name,
        ];
    }
}