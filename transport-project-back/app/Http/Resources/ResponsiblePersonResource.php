<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponsiblePersonResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'responsible_person_id' => $this->responsible_person_id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'second_name' => $this->second_name,
            'full_name' => trim($this->last_name . ' ' . $this->first_name . ' ' . $this->second_name),
            'department' => $this->department,
            'post' => $this->post,
            'phone_number' => $this->phone_number,
        ];
    }
}