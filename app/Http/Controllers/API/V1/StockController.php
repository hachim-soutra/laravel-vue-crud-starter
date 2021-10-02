<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Users\StockRequest;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends BaseController
{

    protected $Stock = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Stock $Stock)
    {
        $this->middleware('auth:api');
        $this->Stock = $Stock;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Stocks = $this->Stock->allPost();

        return $this->sendResponse($Stocks, 'Stock list');
    }
    public function list()
    {
        $Stocks = $this->Stock->latest()->get();

        return $this->sendResponse($Stocks, 'Stock list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockRequest $request)
    {
        $Stock = $this->Stock->create($request->all());

        return $this->sendResponse($Stock, 'Stock Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->Stock->findOrFail($id);

        return $this->sendResponse($product, 'Stock Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $Stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Stock = $this->Stock->findOrFail($id);

        $Stock->update($request->all());

        return $this->sendResponse($Stock, 'Stock Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $Stock
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $Stock = $this->Stock->findOrFail($id);

        $Stock->delete();

        return $this->sendResponse($Stock, 'Stock has been Deleted');

    }
}
