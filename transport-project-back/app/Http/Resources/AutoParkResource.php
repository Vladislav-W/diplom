<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AutoParkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->auto_id,
            'name' => $this->auto_name,              // Название автомобиля
            'state_number' => $this->state_number,    // Госномер
            'capacity' => $this->capacity,            // Грузоподъемность
            'driver' => new DriverResource($this->whenLoaded('driver')), // Водитель (если загружен)
        ];
    }
}