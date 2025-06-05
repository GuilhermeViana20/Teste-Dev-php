<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::apiResource('customers', CustomerController::class)->names([
    'index' => 'api.customers.index',
    'show' => 'api.customers.show',
    'store' => 'api.customers.store',
]);
