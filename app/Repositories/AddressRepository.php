<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AddressRepository
{
    public function __construct(
        protected Address $model
    ) {}

    public function create(array $addressData): Address
    {
        $address = Address::create($addressData);
        $address->address()->create($addressData);

        return $address;
    }

    public function update(array $conditions, array $data): Address
    {
        return $this->model->updateOrCreate($conditions, $data);
    }
}
