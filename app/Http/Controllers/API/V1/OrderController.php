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
use App\Models\Historique;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Stock;
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
    public function index($status = null, City $city = null, Request $request)
    {
        $orders = $this->order->allOrder();
        if ($status) {
            $orders = $orders->where('order_status_id', $status)->whereNull('shipping_id');
        }
        if ($city) {
            $orders = $orders->where('city_id', $city->id);
        }
        if ($request->dateStart && $request->dateEnd) {

            if ($request->dateStart > $request->dateEnd) {
                $orders = $orders->whereBetween('created_at', [$request->dateEnd, $request->dateStart]);
            }
            if ($request->dateStart <= $request->dateEnd) {
                $orders = $orders->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
            }
        }
        if ($request->contact_id) {
            $orders = $orders->where('contact_id', $request->contact_id);
        }

        if ($request->city_id) {
            $orders = $orders->where('city_id', $request->city_id);
        }

        if ($request->produit_id) {
            $orders = $orders->where('product_id', $request->produit_id);
        }

        if ($request->order_status_id) {
            $orders = $orders->where('order_status_id', $request->order_status_id);
        }

        if ($request->status_livraison_id) {
            $orders = $orders->where('status_livraison_id', $request->status_livraison_id);
        }
        return $this->sendResponse(new OrderCollection($orders->sortByDesc('created_at')), 'order list');
    }
    public function getDelivryOrder($shipping_id)
    {
        $orders = $this->order->delivryOrder($shipping_id);
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function getOrderReportie()
    {
        $orders = $this->order->where('order_status_id', 9)->get();
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function getDelivryOrderExpide($shipping_id, Request $request)
    {
        $orders = $this->order->delivryOrderExpide($shipping_id);
        if ($request->dateStart && $request->dateEnd) {

            if ($request->dateStart > $request->dateEnd) {
                $orders = $orders->whereBetween('created_at', [$request->dateEnd, $request->dateStart]);
            }
            if ($request->dateStart <= $request->dateEnd) {
                $orders = $orders->whereBetween('created_at', [$request->dateStart, $request->dateEnd]);
            }
        }

        if ($request->contact_id) {
            $orders = $orders->where('contact_id', $request->contact_id);
        }

        if ($request->city_id) {
            $orders = $orders->where('city_id', $request->city_id);
        }

        if ($request->produit_id) {
            $orders = $orders->where('product_id', $request->produit_id);
        }

        if ($request->order_status_id) {

            $orders = $orders->where('order_status_id', $request->order_status_id);
        }

        if ($request->status_livraison_id) {
            $orders = $orders->where('status_livraison_id', $request->status_livraison_id);
        }
        return $this->sendResponse(new OrderCollection($orders), 'order list');
    }
    public function rammasage(Shipping $shipping, Request $request)
    {
        foreach ($request->orders as $order) {
            $item = Order::find($order["id"]);
            $item->shipping_id = $shipping->id;
            $item->status_livraison_id = 1;
            if($item->product->quantity >= $item->quantity) {
                Historique::create([
                    'order_id' => $item->id,
                    'text' => 'Agent ' . auth()->user()->username . ' ramasser order'
                ]);
            }else {
                return response()->json(
                    [
                        'message' => $item->contact->username.' n\'a pas la quantity '.$item->quantity.'dans le produit '.$item->product->name
                    ], 500);
            }
        }
        foreach ($request->orders as $order) {
            $item = Order::find($order["id"]);
            $item->save();
        }
        return $this->sendResponse($shipping, 'order list');
    }

    public function import(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:cities,id',
            'contact_id' => 'required|exists:contacts,id',
        ]);
        try {
            $import = new OrderImport($request->country_id, $request->contact_id);
            Excel::import($import, $request->file('file'));
            $imported_data = $import->getData();
            return $this->sendResponse(array(), $imported_data['imported'] . ' orders import!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return response()->json([
                'message' => $failures
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = $this->order->create([
            'quantity'          => $request->quantity,
            'order_status_id'   => $request->order_status_id,
            'contact_id'        => $request->contact_id,
            'shipping_id'       => $request->get('shipping_id'),
            'total'             => $request->get('total'),
            'subTotal'          => $request->get('subTotal'),
            'shipping_adresse'  => $request->shipping_adresse,
            'note'              => $request->note,
            'delivery_note'     => $request->delivery_note,
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
        $order->update([
            'quantity'            => $request->quantity,
            'tarif'               => $request->tarif,
            'consumer_phone'      => $request->consumer_phone,
            'consumer_name'       => $request->consumer_name,
            'consumer_ville'      => $request->consumer_ville,
            'order_status_id'     => $request->order_status_id,
            'status_livraison_id' => $request->status_livraison_id,
            'product_id'          => $request->product_id,
            'shipping_id'         => $request->shipping_id,
            'date_reporting'      => $request->order_status_id === 9 ? $request->date_reporting : null,
            'note'                => $request->note,
            'delivery_note'       => $request->delivery_note,
            'shipping_id'         => $request->get('shipping_id'),
            'total'               => $request->quantity * $order->product->price,
            'subTotal'            => $request->quantity * $order->product->price,
            'shipping_adresse'    => $request->shipping_adresse
        ]);
        Historique::create([
            'order_id' => $order->id,
            'text' => 'Agent ' . auth()->user()->username . ' mise a jour order to' . $order->status->name
        ]);
        return $this->sendResponse($order, 'Les informations de commande ont été mises à jour');
    }
    public function relancerOrder(Request $request)
    {
        foreach ($request->orders as $order) {
            $order = Order::find($order["id"]);
            $order->update([
                'order_status_id'     => 1,
                'status_livraison_id' => null,
                'gestion_id'          => null,
                'shipping_id'         => null,
            ]);
            Historique::create([
                'order_id' => $order->id,
                'text' => 'Agent ' . auth()->user()->username . ' relancer order'
            ]);
        }
        return $this->sendResponse($order, 'Les informations de commande ont été mises à jour');
    }
    public function updateStatusLivreur(Request $request, $id)
    {
        $request->validate([
            'status_livraison_id' => 'required|exists:status_livraisons,id',
            'order_status_id' => 'required|exists:order_statuses,id'
        ]);
        $order = Order::findOrFail($id);
        $order->status_livraison_id = $request->status_livraison_id;
        $order->order_status_id     = $request->order_status_id;
        $order->user_id = auth()->user()->id;
        $order->save();
        Historique::create([
            'order_id' => $order->id,
            'text' => 'Agent ' . auth()->user()->username . ' mise a jour order livraison to' . $order->statusLivraison->name
        ]);
        return $this->sendResponse($order, 'Les informations de commande ont été mises à jour');
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
        Historique::create([
            'order_id' => $order->id,
            'text' => 'Agent ' . auth()->user()->username . ' supprimer order'
        ]);
        return $this->sendResponse($order, 'order has been Deleted');
    }
}
