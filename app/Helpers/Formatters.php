<?php

namespace App\Helpers;

class Formatters
{
    public static function formatCpf(?string $cpf): ?string
    {
        if (empty($cpf)) {
            return null;
        }
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) === 11) {
            return substr($cpf, 0, 3) . '.' .
                   substr($cpf, 3, 3) . '.' .
                   substr($cpf, 6, 3) . '-' .
                   substr($cpf, 9, 2);
        }
        return $cpf;
    }

    public static function formatPostalCode(?string $postal_code): ?string
    {
        if (empty($postal_code)) {
            return null;
        }
        $postal_code = preg_replace('/[^0-9]/', '', $postal_code);

        if (strlen($postal_code) === 8) {
            return substr($postal_code, 0, 5) . '-' .
                   substr($postal_code, 5, 3);
        }
        return $postal_code;
    }

    public static function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) === 11) {
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-' . substr($phone, 7, 4);
        } elseif (strlen($phone) === 10) {
            return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-' . substr($phone, 6, 4);
        }
        return $phone;
    }
}
