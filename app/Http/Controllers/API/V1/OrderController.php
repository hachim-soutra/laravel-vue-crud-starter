<?php

namespace App\Http\Controllers\API\V1;

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
use App\Models\City;
use App\Models\Product;
use App\Models\Shipping;
use Maatwebsite\Excel\Facades\Excel;

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
        public function index($status = null,City $city =null)
    {
        $orders = $this->order->allOrder();
        if($status){
            $orders = $orders->where('order_status_id',$status)->whereNull('shipping_id');
        }
        if($city){
            $orders = $orders->where('city_id',$city->id);
        }
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function getDelivryOrder($shipping_id)
    {
        $orders = $this->order->delivryOrder($shipping_id);
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function getDelivryOrderExpide($shipping_id)
    {
        $orders = $this->order->delivryOrderExpide($shipping_id);
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function rammasage(Shipping $shipping, Request $request)
    {
        foreach ($request->orders as $order) {
            $item = Order::find($order["id"]);
            $item->shipping_id = $shipping->id;
            $item->status_livraison_id = 1;
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
            'order_status_id'        => $request->get('status'),
            'consumer_id'   => $user->id,
            'contact_id'   => $request->contact_id,
            'product_id'    => 1,
            'upsell_json'   => $product_json,
            'note_json'     => $note_json,
            'shipping_id'   => $request->get('shipping_id'),
            'shipping_json' => $shipping_json,
            'total'         => $request->get('total'),
            'subTotal'      => $request->get('subTotal'),
            'shipping_adresse' => $request->shipping_adresse
        ]);

        \QrCode::size(500)
            ->format('png')
            ->generate('codingdriver.com', public_path('images/qrcode.png'));

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
            'order_status_id'        => $request->order_status,
            'package'       => $request->package_status,
            'contact_id'     => $request->contact_id,
            'consumer_id'   => $request->consumer_id,
            'product_id'    => 1,
            'datetime'      => $request->datetime,
            'upsell_json'   => $product_json,
            'note_json'     => $note_json,
            'shipping_id'   => $request->get('shipping_id'),
            'shipping_json' => $shipping_json,
            'total'         => $request->get('total'),
            'subTotal'      => $request->get('subTotal'),
            'shipping_adresse' => $request->shipping_adresse
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
        return $this->sendResponse($order, 'order Information has been updated');
    }
    public function updateStatusLivreur(Request $request, $id)
    {
        $request->validate([
            'status_livraison_id' => 'required|exists:status_livraisons,id'
        ]);
        $order = Order::findOrFail($id);
        $order->status_livraison_id = $request->status_livraison_id;
        $order->user_id = auth()->user()->id;
        $order->save();
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
