<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CepService
{
    public function search(string $cep)
    {
        if (str_contains($cep, '-')) {
            if (!preg_match('/^\d{5}-\d{3}$/', $cep)) {
                throw new HttpException(422, 'CEP mal formatado. Use 99999-999 ou 99999999.');
            }

            $cep = str_replace('-', '', $cep);
        } else {
            if (!preg_match('/^\d{8}$/', $cep)) {
                throw new HttpException(422, 'CEP inválido. Use 99999-999 ou 99999999.');
            }
        }

        $response = Http::get("https://brasilapi.com.br/api/cep/v1/{$cep}");

        if ($response->failed()) {
            throw new HttpException(404, 'CEP não encontrado.');
        }

        return $response->json();
    }
}
