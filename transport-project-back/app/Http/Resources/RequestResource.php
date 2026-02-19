<?php
// app/Http/Resources/RequestResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'request_id' => $this->request_id,
            'request_number' => $this->request_number,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Пункт погрузки
            'organization_from' => new OrganizationResource($this->whenLoaded('organizationFrom')),
            'departure_city' => new CityResource($this->whenLoaded('departureCity')),
            'address_from' => $this->address_from,
            'notes_from' => $this->notes_from,
            
            // Пункт разгрузки
            'organization_to' => new OrganizationResource($this->whenLoaded('organizationTo')),
            'arrival_city' => new CityResource($this->whenLoaded('arrivalCity')),
            'address_to' => $this->address_to,
            'notes_to' => $this->notes_to,
            
            // Даты
            'departure_datetime' => $this->departure_datetime,
            'arrival_datetime' => $this->arrival_datetime,
            
            // Ответственный
            'responsible_person' => new ResponsiblePersonResource($this->whenLoaded('responsiblePerson')),
            
            // Доверенность
            'attorney_for_driver' => $this->attorney_for_driver,
            
            // Грузы
            'cargo_items' => CargoItemResource::collection($this->whenLoaded('cargo'))
        ];
    }
}