<?php

namespace App\Http\Controllers\API\Gestion;

use App\Models\Consumer;
use Illuminate\Http\Request;

class ConsumerController extends BaseController
{

    protected $consumer = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consumers = $this->consumer->allPost();

        return $this->sendResponse($consumers, 'Consumer list');
    }
    public function list()
    {
        $consumers = $this->consumer->latest()->get();

        return $this->sendResponse($consumers, 'Consumer list');
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
        $consumer = $this->consumer->create([
            'prenom'        => $request->get('prenom'),
            'nom'           => $request->get('nom'),
            'adresse'       => $request->get('adresse'),
            'ville'         => $request->get('ville'),
            'phone'         => $request->get('phone'),
            'status'        => $request->get('status')
        ]);

        return $this->sendResponse($consumer, 'Consumer Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->consumer->findOrFail($id);

        return $this->sendResponse($product, 'Consumer Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function edit(Consumer $consumer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $consumer = $this->consumer->findOrFail($id);

        $consumer->update($request->all());

        return $this->sendResponse($consumer, 'consumer Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consumer  $consumer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $consumer = $this->consumer->findOrFail($id);

        $consumer->delete();

        return $this->sendResponse($consumer, 'Consumer has been Deleted');

    }
}
