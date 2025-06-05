<?php

namespace App\Services;

use App\Helpers\Formatters;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(
        protected CustomerRepository $customerRepository,
        protected Formatters $formatter
    ) {}

    public function getAllCustomers(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        return $this->customerRepository->getAll($request)
            ->through(function ($customer) {
                $customer->cpf = Formatters::formatCpf($customer->cpf);
                $customer->phone = Formatters::formatPhoneNumber($customer->phone);
                $customer->address->postal_code = Formatters::formatPostalCode($customer->address->postal_code);
                return $customer;
            });
    }

    public function findCustomerById(int $id)
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            return null;
        }

        $customer->cpf = Formatters::formatCpf($customer->cpf);
        $customer->phone = Formatters::formatPhoneNumber($customer->phone);
        $customer->address->postal_code = Formatters::formatPostalCode($customer->address->postal_code);

        return $customer;
    }

    public function createCustomer(array $data): \App\Models\Customer
    {
        if (isset($data['cpf'])) {
            $data['cpf'] = preg_replace('/[^0-9]/', '', $data['cpf']);
        }

        if (isset($data['address']['postal_code'])) {
            $data['address']['postal_code'] = preg_replace('/[^0-9]/', '', $data['address']['postal_code']);
        }

        if (isset($data['phone'])) {
            $data['phone'] = preg_replace('/[^0-9]/', '', $data['phone']);
        }

        $customerData = [
            'name' => $data['name'],
            'surname' => $data['surname'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'phone' => $data['phone'],
        ];

        $addressData = $data['address'];

        return $this->customerRepository->create($customerData, $addressData);
    }

    public function updateCustomer(Request $request, int $id)
    {
        $customer = $this->customerRepository->find($id);

        if (!$customer) {
            throw new \Exception('Cliente não encontrado');
        }

        $updatedCustomer = $this->customerRepository->update($customer, $request->all());

        $updatedCustomer->cpf = Formatters::formatCpf($updatedCustomer->cpf);
        $updatedCustomer->phone = Formatters::formatPhoneNumber($updatedCustomer->phone);
        $updatedCustomer->address->postal_code = Formatters::formatPostalCode($updatedCustomer->address->postal_code);

        return $updatedCustomer;
    }


    public function deleteCustomer($id): bool
    {
        return $this->customerRepository->delete($id);
    }
}
