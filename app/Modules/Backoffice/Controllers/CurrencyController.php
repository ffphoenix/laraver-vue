<?php

namespace Backoffice\Controllers;

use Illuminate\Http\Request;
use Backoffice\Requests\CurrencyForm;
use App\Resources\CurrencyResource;
use App\Resources\CurrencysResource;
use App\Repositories\CurrencyRepository;

class CurrencyController extends Controller
{
    protected $currencyRep;

    public function __construct(CurrencyRepository $currencyRepository){
        $this->currencyRep = $currencyRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        // get all the user
        $providers = $this->currencyRep->getAll($request->all());

        // load the view and pass the user
        return new CurrencysResource($providers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CurrencyForm $request)
    {
        $provider = $this->currencyRep->store($request->all());
        return new CurrencyResource($provider);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $provider = $this->currencyRep->findById($id);
        return new CurrencyResource($provider);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, CurrencyForm $request)
    {
        $data = $request->all();
        $provider = $this->currencyRep->update($id, $data);
        return $provider ? new CurrencyResource($provider) : false;
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
        return $this->currencyRep->destroy($id);
    }

    /**
     * Restore specified resource to storage.
     *
     * @param  int  $id
     * @return Restore
     */
    public function restore($id)
    {
        return $this->currencyRep->restore($id);
    }

    /**
     * Build list for select.
     *
     * @return Json
     */
    public function forselect()
    {
        return response()->json($this->currencyRep->getForSelect());
    }
}
