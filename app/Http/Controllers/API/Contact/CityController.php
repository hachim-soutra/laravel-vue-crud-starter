<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Resources\CityCollection;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class CityController extends BaseController
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

        $countries = new CityCollection(City::latest()->get());

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
        $user = City::create([
            'name' => $request['name'],
        ]);
        return $this->sendResponse($user, 'City Créé avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = new CityResource(City::findOrFail($id));

        return $this->sendResponse($country, 'Country Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:cities,name,' . $id
        ]);
        $country = City::findOrFail($id);
        $country->update($request->all());
        return $this->sendResponse($country, 'country Les informations ont été mises à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}
