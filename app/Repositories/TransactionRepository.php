<?php

namespace App\Repositories;

use App\Repositories\Abstracts\AbstractRepository;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

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
        return $items;
    }

    public function getAllForApi ($filters) {
        $limit = isset($filters['limit']) ? (int)$filters['limit'] : $this->paginate;
        $offset = isset($filters['offset']) ? (int)$filters['offset'] : 0;

        $items = $this->model->select('id as transactionId', 'customer_id as customerId', 'amount', 'created_at as date');

        if (!empty($filters['customerId'])) {
            $items->where('transactions.customer_id', $filters['customerId']);
        }

        if (isset($filters['amount']) && !empty($filters['amount'])) {
            $items->where('transactions.amount', Transaction::convertSum($filters['amount']));
        }

        if (isset($filters['date']) && !empty($filters['date'])) {
            $items->where('transactions.created_at', '>', date('Y-m-d 00:00:00', strtotime($filters['date'])));
            $items->where('transactions.created_at', '<', date('Y-m-d 23:59:59', strtotime($filters['date'])));
        }
        $items->offset($offset)
            ->limit($limit);

        $items = $items->get()->toArray();
        if (!empty($items)) {
            foreach ($items as &$item) {
                $item['date'] = date('d.m.Y', strtotime($item['date']));
                $item['amout'] = Transaction::convertSum($item['amount'], false);
            }
        }
        return $items;
    }

    public function yesterdaySum() {
        $yesterday = time() ;//- 24*60*60;

        $sum = DB::table('transactions')
                ->where('created_at', '>', date('Y-m-d 00:00:00', $yesterday))
                ->where('created_at', '<', date('Y-m-d 23:59:59', $yesterday))
                ->sum('amount');
        $sum = Transaction::convertSum($sum, false);

        DB::table('result')->insert(
            [
                'date' => date('Y-m-d', $yesterday),
                'sum' => $sum
            ]
        );
        return $sum;
    }

}
