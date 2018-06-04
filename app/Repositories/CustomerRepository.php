<?php

namespace App\Repositories;

use App\Repositories\Abstracts\AbstractRepository;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CustomerRepository extends AbstractRepository
{
    protected $currency;

    public function __construct(Customer $model)
    {
        $this->model = $model;
        $this->paginate = env('PAGINATE', 10);
    }

    /**
     * Get records for sellects.
     *
     * @return array
     */
    public function search($query)
    {
        return $this->model->where('name', 'like', '%' .$query . '%')->orWhere('cnp', 'like', "%$query%")->get()->all();
    }

    public function setTableFilter($items, $query)
    {
        $items->where('name', 'like', "%$query%")->orWhere('cnp', 'like', "%$query%");
    }

    /**
     * Remove record.
     *
     * @param int $id
     * @return string
     */
    public function destroy($id)
    {
        $model = $this->model->findOrFail($id);
        return $model->delete() ? 'ok' : 'fail';
    }
}
