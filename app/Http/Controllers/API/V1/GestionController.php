<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\GestionCollection;
use App\Http\Resources\GestionResource;
use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class GestionController extends BaseController
{

    protected $Gestion = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Gestion $Gestion)
    {
        $this->middleware('auth:api');
        $this->Gestion = $Gestion;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Gestions = new GestionCollection($this->Gestion->all());

        return $this->sendResponse($Gestions, 'Gestion list');
    }
    public function list()
    {
        $Gestions = $this->Gestion->latest()->get();

        return $this->sendResponse($Gestions, 'Gestion list');
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
        $Gestion = $this->Gestion->create([
            'prenom'        => $request->get('prenom'),
            'nom'           => $request->get('nom'),
            'adresse'       => $request->get('adresse'),
            'ville'         => $request->get('ville'),
            'city_id'       => $request->get('city_id'),
            'phone'         => $request->get('phone'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request['password']),
        ]);

        return $this->sendResponse($Gestion, 'Agent de gestion Créé avec succès');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gestion  $Gestion
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->Gestion->findOrFail($id);

        return $this->sendResponse($product, 'Gestion Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gestion  $Gestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Gestion $Gestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gestion  $Gestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Gestion = $this->Gestion->findOrFail($id);

        $Gestion->update($request->all());

        return $this->sendResponse($Gestion, 'Les informations ont été mises à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gestion  $Gestion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $Gestion = $this->Gestion->findOrFail($id);

        $Gestion->delete();

        return $this->sendResponse($Gestion, 'Agent de gestion a été supprimé');

    }
}
