<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Models\Client;
use App\Repositories\Repository\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends BaseController
{

    protected $client = '';

    public function __construct(Client $client)
    {
        // $this->middleware('auth:api');
        $this->client = new ClientRepository($client);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = $this->client->get_by_agency(auth()->user()->agence_id);
        return $this->sendResponse($clients, 'client list');
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
        $request->merge(["agence_id" => auth()->user()->agence_id]);
        $clients = $this->client->create($request->all());
        return $this->sendResponse($clients, 'create client');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $client)
    {
        $request->merge(["agence_id" => auth()->user()->agence_id]);
        $clients = $this->client->update($request->all(), $client);
        return $this->sendResponse($clients, 'upadet client');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {
        $clients = $this->client->delete($client);
        return $this->sendResponse($clients, 'delete client');
    }
}
