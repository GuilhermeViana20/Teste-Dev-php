<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Formatters;

class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'street'   => $this->street,
            'neighborhood' => $this->neighborhood,
            'city'     => $this->city,
            'state'    => $this->state,
            'postal_code' => Formatters::formatPostalCode($this->postal_code),
        ];
    }
}
