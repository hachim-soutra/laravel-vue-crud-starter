<?php

namespace App\Http\Controllers\API\Contact;

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

        // $this->authorize('isAdmin');

        $countries = new TransactionCollection(Transaction::latest()->get());

        return $this->sendResponse($countries, 'Countries list');
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:cities'
        ]);
        $user = Transaction::create([
            'name' => $request['name'],
        ]);
        return $this->sendResponse($user, 'Transaction Created Successfully');
    }

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
        // $request->validate([
        //     'name' => 'required|unique:cities,name,' . $id
        // ]);
        $country = Transaction::findOrFail($id);
        $country->update($request->all());
        return $this->sendResponse($country, 'country Information has been updated');
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
