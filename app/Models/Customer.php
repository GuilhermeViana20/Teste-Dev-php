<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'cpf',
        'email',
        'phone',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }
}
