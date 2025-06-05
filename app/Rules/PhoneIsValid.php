<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneIsValid implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^\(\d{2}\)\s9\d{4}-\d{4}$/', $value)) {
            $fail('O campo ' . $attribute . ' deve estar no formato (XX) 9XXXX-XXXX.');
        }
    }
}
