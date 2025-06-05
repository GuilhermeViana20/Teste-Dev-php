<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfIsValid implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $value);

        if (strlen($cpf) !== 11) {
            $fail('O CPF informado não possui 11 dígitos.');
            return;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O CPF informado é inválido. Não pode ter todos os dígitos iguais.');
            return;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += (int)$cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ((int)$cpf[$c] !== $d) {
                $fail('O CPF informado não é válido.');
                return;
            }
        }
    }
}
