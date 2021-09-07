<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Resources\DeliveryMenCollection;
use App\Http\Resources\DeliveryMenResource;
use App\Http\Resources\ShippingCollection;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingController extends BaseController
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
    public function index()
    {
        $shippings = $this->shipping->get();
        return $this->sendResponse(new DeliveryMenCollection($shippings), 'shipping list');
    }
    public function list()
    {
        $shippings = shipping::all();
        return $this->sendResponse($shippings, 'shipping list 333');
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
            'password'  => Hash::make($request->password),
            'price'     => $request->price,
            'dure'      => $request->dure,
            'phone'     => $request->phone,
            'city'      => $request->city,
            'city_id'   => $request->city_id,
            'status'    => $request->status,
        ]);
        return $this->sendResponse($shipping, 'shipping Created Successfully');
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
        return $this->sendResponse($shipping, 'shipping Information has been updated');
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
        return $this->sendResponse($shipping, 'shipping has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);
        return response()->json(['success' => true]);
    }
}
