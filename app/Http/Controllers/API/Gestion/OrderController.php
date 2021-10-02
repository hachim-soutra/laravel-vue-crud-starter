<?php

namespace App\Http\Controllers\API\Gestion;

use App\Http\Controllers\API\V1\BaseController;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Consumer;
use App\Models\Order;
use App\Notifications\newOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Imports\OrderImport;
use App\Models\Historique;
use App\Models\Product;
use App\Models\Shipping;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends BaseController
{
    protected $order = '';

    public function __construct(Order $order)
    {
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = auth()->user()->orderValide;
        return $this->sendResponse(new OrderResource($orders), 'order list');
    }
    public function historique()
    {
        $orders = auth()->user()->orderHistorique;
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function refresh()
    {
        if (auth()->user()->orderValide) {
            return $this->sendResponse(new OrderResource(auth()->user()->orderValide), 'order list');
        }
        $order = $this->order->where('order_status_id', 1)->whereNull('gestion_id')->first();
        $order->gestion_id =  auth()->user()->id;
        $order->save();

        return $this->sendResponse(new OrderResource($order), 'order list');
    }
    public function getDelivryOrder($shipping_id)
    {
        $orders = $this->order->delivryOrder($shipping_id);
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function rammasage(Shipping $shipping, Request $request)
    {
        foreach ($request->orders as $order) {
            $item = Order::find($order["id"]);
            $item->shipping_id = $shipping->id;
            foreach ($order["product_array"] as $produit) {
                $product = Product::find($produit["id"]);
                $product->quantity -= $produit["quantity"];
                $product->save();
            }
            $item->save();
        }
        return $this->sendResponse($shipping, 'order list');
    }

    public function import(Request $request)
    {
        Excel::import(new OrderImport($request->country_id, $request->contact_id), $request->file('file'));
        return $this->sendResponse(array(), 'All good!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->order->findOrFail($id);
        return $this->sendResponse(new OrderResource($order), 'order Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->order_status_id == 1){
            return response()->json(
                [
                    'message' => 'change order status'
                ], 500);
        }

        $total = $request->quantity * Product::findOrFail($request->product_id)->sell;

        $this->order->create([
            'quantity'            => $request->quantity,
            'consumer_phone'      => $request->consumer_phone,
            'consumer_name'       => $request->consumer_name,
            'consumer_ville'      => $request->consumer_ville,
            'order_status_id'     => $request->order_status_id,
            'gestion_id'          => auth()->user()->id,
            'product_id'          => $request->product_id,
            'date_reporting'      => $request->order_status_id === 9 ? $request->date_reporting : null,
            'note'                => $request->note,
            'dateConfirmation'    => now(),
            'delivery_note'       => $request->delivery_note,
            'total'               => $total,
            'subTotal'            => $total,
            'shipping_adresse'    => $request->shipping_adresse
        ]);
        Historique::create([
            'order_id' => $this->order->id,
            'text' => 'Agent Confirmation ' . auth()->user()->id . ' ajouter order avec ' . $this->order->status->name
        ]);
        return $this->sendResponse($this->order, 'order Information has been updated');
    }
    public function update(Request $request, $id)
    {
        if($request->order_status_id == 1){
            return response()->json(
                [
                    'message' => 'change order status'
                ], 500);
        }
        $order = $this->order->findOrFail($id);
        $order->update([
            'quantity'            => $request->quantity,
            'consumer_phone'      => $request->consumer_phone,
            'consumer_name'       => $request->consumer_name,
            'consumer_ville'      => $request->consumer_ville,
            'order_status_id'     => $request->order_status_id,
            'gestion_id'          => auth()->user()->id,
            'date_reporting'      => $request->order_status_id === 9 ? $request->date_reporting : null,
            'note'                => $request->note,
            'dateConfirmation'    => now(),
            'delivery_note'       => $request->delivery_note,
            'total'               => $request->quantity * $order->product->price,
            'subTotal'            => $request->quantity * $order->product->price,
            'shipping_adresse'    => $request->shipping_adresse

        ]);
        Historique::create([
            'order_id' => $order->id,
            'text' => 'Agent Confirmation ' . auth()->user()->id . ' mise a jour order avec ' . $order->status->name
        ]);
        return $this->sendResponse($order, 'order Information has been updated');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id'
        ]);
        $order = $this->order->findOrFail($id);
        $order->update([
            'order_status_id' => $request->order_status_id,
            'user_id'         => auth()->user()->id,

        ]);
        Historique::create([
            'order_id' => $order->id,
            'text' => 'Agent Confirmation ' . auth()->user()->id . ' mise a jour order avec ' . $order->status->name
        ]);
        return $this->sendResponse($order, 'order Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $order = $this->order->findOrFail($id);
        $order->delete();
        return $this->sendResponse($order, 'order has been Deleted');
    }
}
