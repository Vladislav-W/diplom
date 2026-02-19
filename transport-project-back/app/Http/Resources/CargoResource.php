<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CargoResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->cargo_id,
            'name' => $this->cargo_name,
            'taking_date' => $this->date_of_taking_cargo ? $this->date_of_taking_cargo->format('Y-m-d') : null,
            'packaging' => $this->type_of_packaging,
            'weight' => $this->weight_of_cargo,
            'volume' => $this->cargo_volume,
            'quantity' => $this->quantity,
            'unit' => $this->cargo_unit,
            'danger_class' => $this->danger_class,
            'delivery_time' => $this->delivery_time ? $this->delivery_time->format('Y-m-d H:i:s') : null,
            'notes' => $this->notes,
        ];
    }
}