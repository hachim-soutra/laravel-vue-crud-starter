<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController;
use App\Http\Resources\OrderResource;
use App\Models\Consumer;
use App\Models\Order;
use App\Notifications\newOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class OrderController extends BaseController
{
    protected $order = '';

    public function __construct(Order $order)
    {
        $this->middleware('auth:api');
        $this->order = $order;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $orders = $this->order->allOrder();
        if(auth()->user()->role_id !== 1){
            $orders = $orders->where('user_id',auth()->user()->id)->get();
        }

        return $this->sendResponse($orders, 'order list');
    }
    public function getDelivryOrder($shipping_id)
    {
        $orders = $this->order->delivryOrder($shipping_id);
        return $this->sendResponse($orders, 'order list');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $note_json = collect([
            "note"          => $request->note,
            "delivery_note" => $request->delivery_note,
            "sell_shipping_cost" => $request->sell_shipping_cost
        ]);

        $shipping_json = collect([
            "shipping_numero" => $request->shipping_numero,
            "shipping_cost"   => $request->shipping_cost
        ]);

        $product_json = collect();

        $user = Consumer::firstOrNew([
            'prenom' =>  request('consumer.prenom'),
            'nom'    =>  request('consumer.nom')
        ]);
        $user->adresse = request('consumer.adresse');
        $user->ville   = request('consumer.ville');
        $user->phone   = request('consumer.phone');
        $user->save();

        foreach ($request->rows as $produit) {
            $product_json->push([
                "id"          => $produit['id'],
                "active"      => $produit['active'] ? 1 : 0,
                "product"     => $produit['product'],
                "product_name"  => DB::table('products')->where('id', $produit['product'])->first()->name,
                "unit_cost"   => $produit['unit_cost'],
                "quantity"    => $produit['quantity'],
                "sub_total"   => $produit['sub_total']
            ]);
        };

        $order = $this->order->create([
            'quantity'      => $product_json->count(),
            'status'        => $request->get('order_status'),
            'package'       => $request->package_status,
            'source_id'     => $request->source_id,
            'consumer_id'   => $user->id,
            'product_id'    => 1,
            'datetime'      => $request->datetime,
            'upsell_json'   => $product_json,
            'note_json'     => $note_json,
            'shipping_id'   => $request->get('shipping_id'),
            'shipping_json' => $shipping_json,
            'total'         => $request->get('total'),
            'subTotal'      => $request->get('subTotal'),
            'dateConfirmation' => $request->dateConfirmation
        ]);


        $user = auth()->user();

        //FacadesNotification::send($user, $order);
        Notification::send($user, new newOrder($order));
        return $this->sendResponse($order, 'order Created Successfully');
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
    public function update(Request $request, $id)
    {
        $order = $this->order->findOrFail($id);
        // $order->update($request->all());
        $note_json = collect([
            "note"          => $request->note,
            "delivery_note" => $request->delivery_note,
            "sell_shipping_cost" => $request->sell_shipping_cost
        ]);

        $shipping_json = collect([
            "shipping_numero" => $request->shipping_numero,
            "shipping_cost"   => $request->shipping_cost
        ]);

        $product_json = collect();


        $user = Consumer::firstOrNew([
            'prenom' =>  request('consumer.prenom'),
            'nom'    =>  request('consumer.nom')
        ]);
        $user->adresse = request('consumer.adresse');
        $user->ville   = request('consumer.ville');
        $user->phone   = request('consumer.phone');
        $user->save();
        $order->update([
            'quantity'      => $product_json->count(),
            'status'        => $request->order_status,
            'package'       => $request->package_status,
            'source_id'     => $request->source_id,
            'consumer_id'   => $request->consumer_id,
            'product_id'    => 1,
            'datetime'      => $request->datetime,
            'upsell_json'   => $product_json,
            'note_json'     => $note_json,
            'shipping_id'   => $request->get('shipping_id'),
            'shipping_json' => $shipping_json,
            'total'         => $request->get('total'),
            'subTotal'      => $request->get('subTotal'),
            'dateConfirmation' => $request->dateConfirmation
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
