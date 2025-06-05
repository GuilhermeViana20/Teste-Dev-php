<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Services\CepService;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $customers = Cache::tags('customers')->remember('customers_' . md5($request->fullUrl()), 60, function () use ($request) {
                return $this->customerService->getAllCustomers($request);
            });

            return response()->json([
                'message' => $customers->isEmpty() ? 'Nenhum cliente encontrado.' : 'Clientes retornados com sucesso!',
                'data' => $customers,
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function store(CustomerStoreRequest $request, CepService $cepService): JsonResponse
    {
        try {
            $data = $request->validated();

            $cepService->search($data['address']['postal_code']);

            $customer = $this->customerService->createCustomer($data);

            Cache::tags('customers')->flush();

            return response()->json([
                'message' => 'Cliente cadastrado com sucesso!',
                'data' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $cacheKey = 'customer_' . $id;

            $customer = Cache::tags('customers')->remember($cacheKey, 60, function () use ($id) {
                return $this->customerService->findCustomerById($id);
            });

            if (!$customer) {
                return response()->json([
                    'message' => 'Cliente não encontrado!',
                    'data' => []
                ], 404);
            }

            return response()->json([
                'message' => 'Cliente retornado com sucesso!',
                'data' => $customer,
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(CustomerUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $customer = $this->customerService->updateCustomer($request, $id);

            Cache::tags('customers')->flush();

            return response()->json([
                'message' => 'Cliente atualizado com sucesso!',
                'data' => $customer,
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->customerService->deleteCustomer($id);

            if (!$deleted) {
                return response()->json([
                    'message' => 'Cliente não encontrado!',
                    'data' => []
                ], 404);
            }

            Cache::tags('customers')->flush();

            return response()->json([
                'message' => 'Cliente deletado com sucesso!',
                'data' => []
            ], 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    private function errorResponse(\Exception $e): JsonResponse
    {
        return response()->json([
            'message' => $e->getMessage(),
            'data' => []
        ], 500);
    }
}
