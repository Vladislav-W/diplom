<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->driver_id,
            'tab_number' => $this->driver_tab_number,  // Табельный номер
            'full_name' => trim($this->last_name . ' ' . $this->first_name . ' ' . $this->second_name),
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'phone' => $this->driver_phone_number,
        ];
    }
}