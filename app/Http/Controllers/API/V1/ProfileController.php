<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Return the user data
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $response = [
            'success' => true,
            'data'    => auth('api')->user(),
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function dashboard()
    {
        $start = request('start');
        $end = request('end');
        $total = auth()->user()->hasRole(['Super Admin']) ? Order::count() : Order::where('user_id',auth()->user()->id)->count();
        $data["total_orders"]       = auth()->user()->hasRole(['Super Admin']) ? Order::sum('total') : Order::where('user_id',auth()->user()->id)->sum('total');
        $data["sales"]              = $total;
        $data["agent"]              = User::count();
        $data["livreur"]            = Shipping::count();
        $data["product"]            = Product::count();

        $data["confirmed_orders"]   = Order::where("order_status_id", 3)->count();

        $data["in_progress_orders"] = Order::where("status_livraison_id", 1)->count();
        $data["delivred_orders"]    = Order::where("status_livraison_id", 2)->count();


        $data["payed_orders_amount"]       = Order::whereBetween('created_at', [$start, $end])->where("status_livraison_id", 6)->sum('total');

        // orders earning
        $data["payed_order"]                = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 6)->count()) : (Order::where("status_livraison_id", 6)->where('user_id',auth()->user()->id)->count());
        $data["payed_order_progress"]       = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 6)->count()*100/ $total) : (Order::where("status_livraison_id", 6)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["livred_order"]               = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 2)->count()) : (Order::where("status_livraison_id", 2)->where('user_id',auth()->user()->id)->count());
        $data["livred_order_progress"]      = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 2)->count()*100/ $total) : (Order::where("status_livraison_id", 2)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["expedie_order"]              = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 1)->count()) : (Order::where("status_livraison_id", 1)->where('user_id',auth()->user()->id)->count());
        $data["expedie_order_progress"]     = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 1)->count()*100/ $total) : (Order::where("status_livraison_id", 1)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["reporter_order"]             = auth()->user()->hasRole(['Super Admin']) ? Order::where("status_livraison_id", 3)->count() : Order::where("status_livraison_id", 3)->where('user_id',auth()->user()->id)->count();
        $data["reporter_order_progress"]    = auth()->user()->hasRole(['Super Admin']) ? Order::where("status_livraison_id", 3)->count()*100/ $total : Order::where("status_livraison_id", 3)->where('user_id',auth()->user()->id)->count()*100/ $total;

        $data["annuler_order"]              = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 7)->count()) : (Order::where("status_livraison_id", 7)->where('user_id',auth()->user()->id)->count());
        $data["annuler_order_progress"]     = auth()->user()->hasRole(['Super Admin']) ? (Order::where("status_livraison_id", 7)->count()*100/ $total) : (Order::where("status_livraison_id", 7)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["other_order"]                = auth()->user()->hasRole(['Super Admin']) ? (Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->count()) : (Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->where('user_id',auth()->user()->id)->count());
        $data["other_order_progress"]       = auth()->user()->hasRole(['Super Admin']) ? (Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->count()*100/ $total) : (Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->where('user_id',auth()->user()->id)->count()*100/ $total);

        // orders status

        $data["expedie_order_status"]           = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 1)->count()) : (Order::where("order_status_id", 1)->where('user_id',auth()->user()->id)->count());
        $data["expedie_order_status_progress"]  = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 1)->count()*100/ $total) : (Order::where("order_status_id", 1)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["confirme_order_status"]              = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 3)->count()) : (Order::where("order_status_id", 3)->where('user_id',auth()->user()->id)->count());
        $data["confirme_order_status_progress"]     = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 3)->count()*100/ $total) : (Order::where("order_status_id", 3)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["reporter_order_status"]              = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 9)->count()) : (Order::where("order_status_id", 9)->where('user_id',auth()->user()->id)->count());
        $data["reporter_order_status_progress"]     = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 9)->count()*100/ $total) : (Order::where("order_status_id", 9)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["waitting_order_status"]              = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 4)->count()) : (Order::where("order_status_id", 4)->where('user_id',auth()->user()->id)->count());
        $data["waitting_order_status_progress"]     = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 4)->count()*100/ $total) : (Order::where("order_status_id", 4)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["annuler_order_status"]               = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 7)->count()) : (Order::where("order_status_id", 7)->where('user_id',auth()->user()->id)->count());
        $data["annuler_order_status_progress"]      = auth()->user()->hasRole(['Super Admin']) ? (Order::where("order_status_id", 7)->count()*100/ $total) : (Order::where("order_status_id", 7)->where('user_id',auth()->user()->id)->count()*100/ $total);

        $data["other_order_status"]             = auth()->user()->hasRole(['Super Admin']) ? (Order::whereNotIN("order_status_id", [6, 2, 1, 3, 7])->count()) : (Order::whereNotIN("order_status_id", [6, 2, 1, 3, 7])->where('user_id',auth()->user()->id)->count()) ;
        $data["other_order_status_progress"]    = auth()->user()->hasRole(['Super Admin']) ? (Order::whereNotIN("order_status_id", [6, 2, 1, 3, 7])->count()*100/ $total) : (Order::whereNotIN("order_status_id", [6, 2, 1, 3, 7])->where('user_id',auth()->user()->id)->count()*100/ $total);


        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function getProduct()
    {
        $start = request('start');
        $end = request('end');
        $products = Product::all();
        $col = collect();
        foreach ($products as $product) {
            $col->push([
                "name" => $product->name, "count" => $product->orders->whereBetween('created_at', [$start, $end])->count()
            ]);
        }
        $data["products"] = $col;
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function getDelivery()
    {
        $start = request('start');
        $end = request('end');
        $products = Shipping::where("type", "men")->get();
        $col = collect();
        foreach ($products as $product) {
            $col->push([
                "name" => $product->name, "count" => $product->orders->whereBetween('created_at', [$start, $end])->count()
            ]);
        }
        $data["delivery"] = $col;
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function getCompany()
    {
        $start = request('start');
        $end = request('end');
        $products = Shipping::where("type", "!=", "men")->get();
        $col = collect();
        foreach ($products as $product) {
            $col->push([
                "name" => $product->name, "count" => $product->orders->whereBetween('created_at', [$start, $end])->count()
            ]);
        }
        $data["delivery"] = $col;
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function getCity()
    {
        $start = request('start');
        $end = request('end');
        $orders =
            DB::table('orders')
            // ->whereBetween('created_at', [$start, $end])
            ->select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->get();

        $col = collect();
        foreach ($orders as $order) {
            $item = Order::where("city", $order->city)->whereBetween('created_at', [$start, $end])->get();
            $col->push([
                "name"      => $order->city,
                "total"     => $item->count(),
                "return"    => $item->count() ? 100 * $item->where("status", "RETURN")->count() / $item->count() : 0,
                "payed"     => $item->count() ? 100 * $item->where("status", "PAID")->count() / $item->count() : 0,
                "en_cours"  => $item->count() ? 100 * $item->where("status", "PROCESSED")->count() / $item->count() : 0,
                "others"    => $item->count() ? 100 * $item->whereNotIn("status", ["PROCESSED", "PAID", "RETURN"])->count() / $item->count() : 0
            ]);
        }
        $data["city"] = $col;
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    public function getAgent()
    {
        $start = request('start');
        $end = request('end');
        $orders =
            DB::table('orders')
            ->select('user_id', DB::raw('count(*) as total'))
            ->groupBy('user_id')
            ->get();;

        $col = collect();
        foreach ($orders as $order) {
            $item = Order::where("user_id", $order->user_id)->whereBetween('created_at', [$start, $end])->get();
            $col->push([
                "name"      => $item[0]->user->name,
                "total"     => $item->count(),
                "return"    => $item->count() ? 100 * $item->where("status", "RETURN")->count() / $item->count() : 0,
                "payed"     => $item->count() ? 100 * $item->where("status", "PAID")->count() / $item->count() : 0,
                "en_cours"  => $item->count() ? 100 * $item->where("status", "PROCESSED")->count() / $item->count() : 0,
                "others"    => $item->count() ? 100 * $item->whereNotIn("status", ["PROCESSED", "PAID", "RETURN"])->count() / $item->count() : 0
            ]);
        }
        $data["agent"] = $col;
        $response = [
            'success' => true,
            'data'    => $data,
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the profile by users
     *
     * @param  \App\Http\Requests\Users\ProfileUpdateRequest  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = auth('api')->user();

        $user->update($request->all());

        $response = [
            'success' => true,
            'data'    => $user,
            'message' => 'Profile has been updated',
        ];
        return response()->json($response, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Users\ChangePasswordRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        User::find(auth('api')->user()->id)->update(['password' => encrypt($request->new_password)]);

        $response = [
            'success' => true,
            'data'    => [],
            'message' => 'Password Has been updated',
        ];
        return response()->json($response, 200);
    }
}
