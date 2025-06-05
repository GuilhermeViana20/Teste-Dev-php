<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Customer;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->count(5)
            ->has(Address::factory()->count(1), 'address')
            ->create();
    }
}
