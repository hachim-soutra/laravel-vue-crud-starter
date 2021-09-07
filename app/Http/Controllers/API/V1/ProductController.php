<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends BaseController
{

    protected $product = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->middleware('role:Super Admin|permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);

        $this->middleware('role:Super Admin|permission:product-create', ['only' => ['create','store']]);

        $this->middleware('role:Super Admin|permission:product-edit', ['only' => ['edit','update']]);

        $this->middleware('role:Super Admin|permission:product-delete', ['only' => ['destroy']]);

        $this->middleware('auth:api');
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->latest()->get();

        return $this->sendResponse($products, 'Product list');
    }
    public function list()
    {
        $products = $this->product->latest()->get();

        return $this->sendResponse($products, 'Product list');
    }
    public function stock(Contact $contact)
    {
        $products = $this->product->latest()->get();

        return $this->sendResponse($products, 'Product list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Products\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $offre_json = collect();
        foreach ($request->offre as $key => $produit) {
            $offre_json->push([
                "id"          => $key,
                "unit_cost"   => $produit['unit_cost'],
                "quantity"    => $produit['quantity'],
            ]);
        };
        $product = $this->product->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'sell' => $request->get('sell'),
            'user_id' => auth()->user()->id,
            'offre_json' => $offre_json,
            'quantity' => $request->get('quantity'),
        ]);

        return $this->sendResponse($product, 'Product Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = $this->product->findOrFail($id);

        return $this->sendResponse(new ProductResource($product), 'Product Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $product = $this->product->findOrFail($id);
        $offre_json = collect();
        foreach ($request->offre as $key => $produit) {
            $offre_json->push([
                "id"          => $key,
                "unit_cost"   => $produit['unit_cost'],
                "quantity"    => $produit['quantity'],
            ]);
        };
        $request->merge([
            'offre_json' => $offre_json,
        ]);
        $product->update($request->all());
        return $this->sendResponse($product, 'Product Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $product = $this->product->findOrFail($id);

        $product->delete();

        return $this->sendResponse($product, 'Product has been Deleted');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
