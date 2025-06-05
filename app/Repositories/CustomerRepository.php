<?php

namespace App\Repositories;

use App\Filters\CustomerFilter;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository
{
    public function __construct(
        protected Customer $model,
        protected AddressRepository $addressRepository
    ) {}

    public function getAll(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('address')->orderBy('name');
        $query = (new CustomerFilter($request))->apply($query);
        return $query->paginate($perPage);
    }

    public function find(int $id)
    {
        return Customer::with('address')->find($id);
    }

    public function create(array $customerData, array $addressData): Customer
    {
        $customer = Customer::create($customerData);
        $customer->address()->create($addressData);

        return $customer;
    }

    public function update(Customer $customer, array $data)
    {
        $addressData = $data['address'] ?? [];

        $customer->update($data);

        if (!empty($addressData)) {
            $this->addressRepository->update(
                ['customer_id' => $customer->id],
                $addressData
            );
        }

        return $customer->load('address');
    }

    public function delete($id): bool
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return false;
        }

        return $customer->delete();
    }
}
