<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Abstracts\AbstractRepository;

class CurrencyRepository extends AbstractRepository
{
    public function __construct(Currency $model)
    {
        $this->model = $model;
        $this->paginate = env('PAGINATE', 10);
    }
}
