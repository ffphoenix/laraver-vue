<?php

namespace Api\Controllers;

use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Api\Requests\TransactionForm;
use App\Resources\TransactionResource as TransactionResource;
use App\Resources\TransactionsResource as TransactionsResource;

class TransactionController extends Controller
{
    protected $transactionRep;

    public function __construct(TransactionRepository $transactionRepository){
        $this->transactionRep = $transactionRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // get all the transaction
        $transactions = $this->transactionRep->getAll($request->all());

        // load the view and pass the transaction
        return new TransactionsResource($transactions);
    }
}
