<?php

namespace App\Http\Resources;

use App\Helpers\Formatters;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'nome'  => $this->name,
            'email' => $this->email,
            'cpf'   => Formatters::formatCpf($this->cpf),
            'address' => new AddressResource($this->whenLoaded('address')),
        ];
    }
}
