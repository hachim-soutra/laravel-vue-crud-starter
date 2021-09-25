<?php

namespace App\Http\Controllers\API\Contact;

use Illuminate\Http\Request;
use App\Http\Resources\StatusCollection;
use App\Http\Resources\StatusResource;
use App\Models\StatusLivraison;

class LivreurStatusController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = new StatusCollection(StatusLivraison::latest()->get());

        return $this->sendResponse($countries, 'Status list');
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
            'name' => 'required|unique:order_statuses'
        ]);
        $user = StatusLivraison::create([
            'name' => $request['name'],
        ]);
        return $this->sendResponse($user, 'Status Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LivreurStatus  $LivreurStatus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = new StatusResource(StatusLivraison::findOrFail($id));

        return $this->sendResponse($country, 'Status Details');
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LivreurStatus  $LivreurStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:order_statuses,name,' . $id
        ]);
        $status = StatusLivraison::findOrFail($id);
        $status->update($request->all());


        return $this->sendResponse($status, 'Status Information has been updated');
    }
}
