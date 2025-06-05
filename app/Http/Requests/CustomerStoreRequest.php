<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfIsValid;
use App\Rules\PhoneIsValid;

class CustomerStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                'unique:customers,cpf',
                new CpfIsValid(),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:customers,email',
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/',
                new PhoneIsValid(),
            ],
            'address' => 'required|array',
            'address.postal_code' => 'required|string',
            'address.street' => 'required|string|max:255',
            'address.neighborhood' => 'required|string|max:255',
            'address.city' => 'required|string|max:255',
            'address.state' => 'required|string|size:2',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'surname.required' => 'O sobrenome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'cpf.min'        => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.max'        => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.digits'     => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.regex'      => 'O formato do CPF deve ser XXX.XXX.XXX-XX (ex: 123.456.789-00).',
            'cpf.cpf_is_valid' => 'O CPF informado não é válido.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'phone.required' => 'O telefone é obrigatório.',
            'phone.regex'      => 'O campo telefone deve estar no formato (XX) 9XXXX-XXXX.',
            'postal_code.required' => 'O CEP é obrigatório.',
            'street.required' => 'A rua é obrigatória.',
            'neighborhood.required' => 'O bairro é obrigatório.',
            'city.required' => 'A cidade é obrigatória.',
            'state.required' => 'O estado é obrigatório.',
            'state.max' => 'O estado deve ter no máximo 2 caracteres.',
        ];
    }
}
