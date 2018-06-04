<?php

namespace App\Repositories;

use App\Exceptions\BadRequestException;
use App\Repositories\Abstracts\AbstractRepository;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class TransactionRepository extends AbstractRepository
{
    public function __construct(Transaction $model)
    {
        $this->model = $model;
        $this->paginate = env('PAGINATE', 25);
    }

    public function convertSum($amount, $toDbValues = true)
    {
        return Transaction::convertSum($amount, $toDbValues);
    }

    public function getAll($filters)
    {
        $query = isset($filters['search']) ? $filters['search'] : null ;
        $sort = isset($filters['sort']) ? $filters['sort'] : null;
        $direction = isset($filters['dir']) && in_array($filters['dir'], ['asc', 'desc']) ? $filters['dir'] : 'desc';
        $columns = \Schema::getColumnListing($this->model->getTable());
        $limit = isset($filters['limit']) ? (int)$filters['limit'] : $this->paginate;
        $currentPage = isset($filters['page']) ? (int)$filters['page'] : 1;

        $items = $this->model->select('transactions.*');

        if (!empty($filters['searchTransactionID'])) {
            $items->where('transactions.id', '=', (int)$filters['searchTransactionID']);
        }

        if (!empty($filters['searchPlayerID'])) {
            $filters['searchPlayerID'];
        }

        if (in_array($sort, $columns)) {
            $items->orderBy('transactions.' . $sort, $direction);
        }

        if (isset($filters['dateFrom']) && !empty($filters['dateFrom'])) {
            $items->where('transactions.created_at', '>', date('Y-m-d H:i:s', strtotime($filters['dateFrom'])));
        }

        if (isset($filters['dateTo']) && !empty($filters['dateTo'])) {
            $items->where('transactions.created_at', '<', date('Y-m-d H:i:s', strtotime($filters['dateTo'])));
        }

        $this->setPage($currentPage);

        $items = $items->paginate($limit);
//        dd(DB::getQueryLog());
        return $items;
    }
}
