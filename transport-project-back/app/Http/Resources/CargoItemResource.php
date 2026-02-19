<?php
// app/Http/Resources/CargoItemResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CargoItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'cargo_id' => $this->cargo_id,
            'name' => $this->cargo_name,
            'quantity' => $this->pivot->quantity,
            'unit' => $this->pivot->unit,
            'type_of_packaging' => $this->type_of_packaging,
            'weight_of_cargo' => $this->weight_of_cargo,
            'cargo_volume' => $this->cargo_volume
        ];
    }
}