<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'postal_code' => '60150165',
            'street' => 'Av. Santos Dumont, 3131',
            'neighborhood' => 'Aldeota',
            'city' => 'Fortaleza',
            'state' => 'CE',
        ];
    }
}
