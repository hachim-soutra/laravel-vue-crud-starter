<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangePasswordRequest;
use App\Http\Requests\Users\ProfileUpdateRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Transaction;
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
        $total                      = Order::where('contact_id', auth()->user()->id)->count();
        $data["total_orders"]       = Order::where('contact_id', auth()->user()->id)->sum('total');
        $data["sales"]              = $total;
        $data["agent"]              = User::count();
        $data["livreur"]            = Transaction::where('contact_id', auth()->user()->id)->count();
        $data["product"]            = Product::where('contact_id', auth()->user()->id)->count();

        $data["confirmed_orders"]   = Order::where("order_status_id", 3)->where('contact_id', auth()->user()->id)->count();

        $data["in_progress_orders"]                 = Order::where("status_livraison_id", 1)->where('contact_id', auth()->user()->id)->count();
        $data["delivred_orders"]                    = Order::where("status_livraison_id", 2)->where('contact_id', auth()->user()->id)->count();

        $data["payed_orders_amount"]                = Order::whereBetween('created_at', [$start, $end])->where("status_livraison_id", 6)->where('contact_id', auth()->user()->id)->sum('total');

        // orders earning
        $data["payed_order"]                        = Order::where("status_livraison_id", 6)->where('contact_id', auth()->user()->id)->count();
        $data["payed_order_progress"]               = Order::where("status_livraison_id", 6)->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        $data["livred_order"]                       = Order::where("status_livraison_id", 2)->where('contact_id', auth()->user()->id)->count();
        $data["livred_order_progress"]              = Order::where("status_livraison_id", 2)->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        $data["expedie_order"]                      = Order::where("status_livraison_id", 1)->where('contact_id', auth()->user()->id)->count();
        $data["expedie_order_progress"]             = Order::where("status_livraison_id", 1)->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        $data["reporter_order"]                     = Order::where("status_livraison_id", 3)->where('contact_id', auth()->user()->id)->count();
        $data["reporter_order_progress"]            = Order::where("status_livraison_id", 3)->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        $data["annuler_order"]                      = Order::where("status_livraison_id", 7)->where('contact_id', auth()->user()->id)->count();
        $data["annuler_order_progress"]             = Order::where("status_livraison_id", 7)->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        $data["other_order"]                        = Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->where('contact_id', auth()->user()->id)->count();
        $data["other_order_progress"]               = Order::whereNotIN("status_livraison_id", [6, 2, 1, 3, 7])->where('contact_id', auth()->user()->id)->count() * 100 / $total;

        // orders status

        $data["expedie_order_status"]               =  (Order::where("order_status_id", 1)->where('contact_id', auth()->user()->id)->count());
        $data["expedie_order_status_progress"]      =  (Order::where("order_status_id", 1)->where('contact_id', auth()->user()->id)->count() * 100 / $total);

        $data["confirme_order_status"]              =  (Order::where("order_status_id", 3)->where('contact_id', auth()->user()->id)->count());
        $data["confirme_order_status_progress"]     =  (Order::where("order_status_id", 3)->where('contact_id', auth()->user()->id)->count() * 100 / $total);

        $data["reporter_order_status"]              =  (Order::where("order_status_id", 9)->where('contact_id', auth()->user()->id)->count());
        $data["reporter_order_status_progress"]     =  (Order::where("order_status_id", 9)->where('contact_id', auth()->user()->id)->count() * 100 / $total);

        $data["waitting_order_status"]              =  (Order::where("order_status_id", 8)->where('contact_id', auth()->user()->id)->count());
        $data["waitting_order_status_progress"]     =  (Order::where("order_status_id", 8)->where('contact_id', auth()->user()->id)->count() * 100 / $total);

        $data["annuler_order_status"]               =  (Order::where("order_status_id", 7)->where('contact_id', auth()->user()->id)->count());
        $data["annuler_order_status_progress"]      =  (Order::where("order_status_id", 7)->where('contact_id', auth()->user()->id)->count() * 100 / $total);

        $data["other_order_status"]                 =  (Order::whereNotIN("order_status_id", [8, 9, 1, 3, 7])->where('contact_id', auth()->user()->id)->count());
        $data["other_order_status_progress"]        =  (Order::whereNotIN("order_status_id", [8, 9, 1, 3, 7])->where('contact_id', auth()->user()->id)->count() * 100 / $total);


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
