<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CustomerFilter
{
    protected $request;
    protected $builder;

    protected $filters = ['name', 'surname', 'cpf', 'cep'];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters as $filter) {
            $method = 'filter'.ucfirst($filter);
            if (method_exists($this, $method) && $this->request->filled($filter)) {
                $this->$method($this->request->input($filter));
            }
        }

        return $this->builder;
    }

    protected function filterName($value)
    {
        $this->builder->whereRaw("CONCAT(name, ' ', surname) LIKE ?", ["%{$value}%"]);
    }

    protected function filterCpf($value)
    {
        $cpf = preg_replace('/[^0-9]/', '', $value);
        $this->builder->where('cpf', 'like', "%{$cpf}%");
    }

    protected function filterCep($value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);
        $this->builder->whereHas('address', function($q) use ($cep) {
            $q->where('postal_code', 'like', "%{$cep}%");
        });
    }
}
