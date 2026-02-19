<?php
// app/Http/Resources/OrganizationResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'organization_id' => $this->organization_id,
            'name' => $this->name,
        ];
    }
}