<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\TransactionCollection;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{

    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = new TransactionCollection(Transaction::latest()->get());

        return $this->sendResponse($countries, 'Countries list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $Transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = new TransactionResource(Transaction::findOrFail($id));

        return $this->sendResponse($country, 'Country Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $Transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = Transaction::findOrFail($id);
        $country->update([
            'date_payment' => now()
        ]);
        return $this->sendResponse($country, 'Les informations ont été mises à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $Transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $Transaction)
    {
        //
    }
}
