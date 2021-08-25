<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Colis;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data  = Colis::where('user_id', auth()->user()->id)->paginate(15);
        $res['data'] = $data;
        $res['msg']  = "success";
        return response($res, 200);
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
        Colis::create([
            'name' => $request->name,
            'status' => $request->status,
            'phone' => $request->phone,
            'ville_depart' => auth()->user()->agence_id,
            'ville_arrive' => $request->vile_arrive,
            'user_id' => auth()->user()->id,
            'client_id' => 1,
            'description' => $request->description,
            'montant' => $request->montant
        ]);
        $res['msg']  = "success";
        return response($res, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function show(colis $colis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function edit(colis $colis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, colis $colis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\colis  $colis
     * @return \Illuminate\Http\Response
     */
    public function destroy(colis $colis)
    {
        //
    }
}
