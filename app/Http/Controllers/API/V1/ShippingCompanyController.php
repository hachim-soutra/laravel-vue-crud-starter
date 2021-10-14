<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\DeliveryMenResource;
use App\Models\City;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingCompanyController extends BaseController
{
    protected $shipping = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(shipping $shipping)
    {
        $this->middleware('auth:api');
        $this->shipping = $shipping;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(City $city =null)
    {
        $shippings = $this->shipping->where("type", "!=", "men")->get();
        if($city){
            $shippings = $shippings->where('city_id',$city->id);
        }

        return $this->sendResponse($shippings, 'shipping list 11');
    }
    public function list()
    {
        $shippings = shipping::all();

        return $this->sendResponse($shippings, 'shipping list 222');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\shippings\shippingRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $shipping = $this->shipping->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => encrypt($request->password),
            'price'     => $request->price,
            'type'      => $request->type,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'status'      => $request->status,
        ]);
        return $this->sendResponse($shipping, 'Livreur créé avec succès');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipping = new DeliveryMenResource($this->shipping->findOrFail($id));
        return $this->sendResponse($shipping, 'shipping Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\shipping  $shipping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shipping = $this->shipping->findOrFail($id);
        $shipping->update($request->all());
        return $this->sendResponse($shipping, 'Les informations ont été mises à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $shipping = $this->shipping->findOrFail($id);

        $shipping->delete();

        return $this->sendResponse($shipping, 'livreur a été supprimé');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
