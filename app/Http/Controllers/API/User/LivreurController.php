<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\API\BaseController;
use App\Models\Livreur;
use App\Repositories\Repository\LivreurRepository;
use Illuminate\Http\Request;

class LivreurController extends BaseController
{

    protected $Livreur = '';

    public function __construct(Livreur $Livreur)
    {
        // $this->middleware('auth:api');
        $this->Livreur = new LivreurRepository($Livreur);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Livreurs = $this->Livreur->get_by_agency(auth()->user()->agence_id);
        return $this->sendResponse($Livreurs, 'Livreur list');
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
        $Livreurs = $this->Livreur->create($request->all());
        return $this->sendResponse($Livreurs, 'Livreur list');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Livreur  $Livreur
     * @return \Illuminate\Http\Response
     */
    public function show(Livreur $Livreur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Livreur  $Livreur
     * @return \Illuminate\Http\Response
     */
    public function edit(Livreur $Livreur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Livreur  $Livreur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Livreur)
    {
        $clients = $this->Livreur->update($request->all(), $Livreur);
        return $this->sendResponse($clients, 'upadet livreur');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Livreur  $Livreur
     * @return \Illuminate\Http\Response
     */
    public function destroy($Livreur)
    {
        $this->Livreur->delete($Livreur);
        return $this->sendResponse([], 'delete livreur');
    }
}
