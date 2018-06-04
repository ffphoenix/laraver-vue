<?php

namespace Api\Controllers;

use App\Exceptions\BadRequestException;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Backoffice\Requests\TransactionForm;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionRep;

    public function __construct(TransactionRepository $transactionRepository){
        $this->transactionRep = $transactionRepository;
    }

    /**
     * @api {get} /transactions/:customerid/:transactionId View a Transaction
     * @apiGroup Transaction
     * @apiName View a Transaction
     * @apiDescription Returns Transaction info
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerid System Customer ID
     * @apiParam {number} transactionId System Transaction ID
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *     "data":{
     *       "id":12,
     *       "name":"testcustomer",
     *       "username":"testcustomer",
     *       "email":"testcustomer@gmail.com",
     *       ]
     *     }
     *   }
     * @apiUse AuthHeader
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
     */
    public function show(int $customerId, int $transactionId)
    {
        $transaction = Transaction::where('id', $transactionId)
            ->where('customer_id', $customerId)
            ->withTrashed()
            ->first();

        if (empty($transaction)) {
            throw new BadRequestException('not_found', 'Transaction not found');
        }
        return [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer->id,
            'amount' => $transaction->getAmount(),
            'date' => date('d.m.Y', strtotime($transaction->created_at))
        ];
    }

    /**
     * @api {get} /transactions?customerId=33&amount=9.99&date=04-06-2018 View Transactions list
     * @apiGroup Transaction
     * @apiName View a Transaction
     * @apiDescription Returns Transaction info
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerId System Customer ID
     * @apiParam {number} amount
     * @apiParam {date}   date Format dd-mm-yyyy
     * @apiParam {offset} offset
     * @apiParam {limit}  limit
     *
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *     "data":{
     *       "id":12,
     *       "name":"testcustomer",
     *       "username":"testcustomer",
     *       "email":"testcustomer@gmail.com",
     *       ]
     *     }
     *   }
     * @apiUse AuthHeader
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized customer
     */
    public function list(Request $request)
    {
        $transactions = $this->transactionRep->getAllForApi($request->all());
        if (empty($transactions)) {
            throw new BadRequestException('not_found', 'Transaction not found');
        }
        return $transactions;
    }

    /**
     * @api {post} /api/transation Create transaction
     * @apiGroup Transaction
     * @apiName Create Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerId customer ID
     * @apiParam {float} amount amount of transfer in format [0.99]
     * @apiParamExample {json} Request-Example:
     *     {
     *       "customer_id":11,
     *       "amount": "33.33",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *       "transactionId":12,
     *       "customerId":11,
     *       "amount": "33.33",
     *       "date": "2018-06-04 10:08:41",
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized Admin
     */
    public function store(TransactionForm $request)
    {
        $requestData = $request->all();
        $requestData['status'] = Transaction::TRANSFER_STATUS_SUCCEEDED;
        $requestData['amount'] = Transaction::convertSum($requestData['amount']);
        $transaction = $this->transactionRep->store($requestData);
        return [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer->id,
            'amount' => $transaction->getAmount(),
            'date' => date('d.m.Y', strtotime($transaction->created_at))
        ];
    }

    /**
     * @api {put} /api/transation/:transactionId Update transaction
     * @apiGroup Transaction
     * @apiName Update Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} transactionId ID
     * @apiParam {float} amount amount of transfer in format [0.99]
     * @apiParamExample {json} Request-Example:
     *     {
     *       "transaction_id":3,
     *       "amount": "33.33",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *       "transactionId":12,
     *       "customerId":11,
     *       "amount": "33.33",
     *       "date": "2018-06-04 10:08:41",
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized Admin
     */
    public function update(int $id, TransactionForm $request)
    {
        $requestData = [];
        $requestData['amount'] = Transaction::convertSum($request->get('amount'));
        $transaction = $this->transactionRep->update($id, $requestData);
        return [
            'transactionId' => $transaction->id,
            'customerId' => $transaction->customer->id,
            'amount' => $transaction->getAmount(),
            'date' => date('d.m.Y', strtotime($transaction->created_at))
        ];
    }

    /**
     * @api {delete} /api/transation/:transactionId delete transaction
     * @apiGroup Transaction
     * @apiName Delete Transaction
     * @apiVersion 0.9.9
     *
     * @apiParam {number} transactionId ID
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *       "fail"
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized Admin
     */
    public function destroy($id)
    {
        // delete
        return ($this->transactionRep->destroy($id)) ? 'success' : 'fail';
    }

}
