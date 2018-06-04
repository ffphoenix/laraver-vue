<?php

namespace Api\Controllers;

use Illuminate\Http\Request;
use Backoffice\Requests\CustomerForm;
use App\Resources\CustomerResource;
use App\Resources\CustomersResource;
use App\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    protected $customerRep;

    public function __construct(CustomerRepository $customerRepository){
        $this->customerRep = $customerRepository;
    }

    /**
     * @api {post} /api/customer Create customer
     * @apiGroup Customer
     * @apiName Create customer
     * @apiVersion 0.9.9
     *
     * @apiParam {sting} name Customer name
     * @apiParam {cnp} cnp Card not present
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": "Test Name",
     *       "cnp":"bbb50097-2d88-3941-9152-67343b1e42e7",
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *       "customerId":12
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized Admin
     */
    public function store(CustomerForm $request)
    {
        $customer = $this->customerRep->store($request->all());
        return [ 'customerId' => $customer->id ];
    }

    /**
     * @api {get} /customers/:customerid View a Customer
     * @apiGroup Customer
     * @apiName View a Customer
     * @apiDescription Returns Customer info
     * @apiVersion 0.9.9
     *
     * @apiParam {number} customerid System Customer ID
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
    public function show($id)
    {
        $customer = $this->customerRep->findById($id);
        return new CustomerResource($customer);
    }

    /**
     * @api {put} /customers/:customerid Update customer
     * @apiGroup Customer
     * @apiName Update customer
     * @apiVersion 0.9.9
     *
     * @apiParam {numder} customerid Customer ID
     * @apiParam {sting} name Customer name
     * @apiParam {email} email Customer email
     * @apiParam {sting} username Customer username
     * @apiParamExample {json} Request-Example:
     *     {
     *       "name": "APICustomer",
     *       "email":"apitest@yopmail.com",
     *       "username": "testcustomer"
     *     }
     *
     * @apiSuccessExample  {json} Success-Response:
     *     HTTP/1.1 200 OK
     *   {
     *     "data":{
     *       "id":12,
     *       "name":"testcustomer",
     *       "username":"testcustomer",
     *       "email":"testcustomer@gmail.com",
     *     }
     *   }
     *
     * @apiUse AuthHeader
     * @apiUse FailedValidation
     * @apiUse UnauthorizedError
     * @apiSampleRequest off
     * @apiPermission Authorized Admin
     */
    public function update($id, CustomerForm $request)
    {
        $data = $request->all();
        $customer = $this->customerRep->update($id, $data);
        return $customer ? new CustomerResource($customer) : false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        return $this->customerRep->destroy($id);
    }

    /**
     * Restore specified resource to storage.
     *
     * @param  int  $id
     * @return Restore
     */
    public function restore($id)
    {
        return $this->customerRep->restore($id);
    }

    /**
     * Search customers for typehead
     *
     * @param  Request  $request
     * @return Response
     */
    public function search(Request $request)
    {
        return $this->customerRep->search($request->get('search'));
    }
}
