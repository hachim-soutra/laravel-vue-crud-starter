<?php

namespace App\Http\Controllers\API\Contact;

use App\Http\Requests\Products\ProductContactRequest;
use App\Http\Requests\Products\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\StockCollection;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Stock;
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
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = auth()->user()->products;
        return $this->sendResponse(new ProductCollection($products), 'Product list');
    }
    public function list()
    {
        $products = auth()->user()->products;
        return $this->sendResponse($products, 'Product list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Products\ProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductContactRequest $request)
    {

        $imageName = time().'.'.$request->image->extension();

        $request->image->storeAs('public/images', $imageName);
        $product = $this->product->create([
            'name' => $request->get('name'),
            'image' => $imageName,
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'sell' => $request->get('sell'),
            'user_id' => auth()->user()->id,
            'contact_id' => auth()->user()->id,
            'quantity' => $request->get('quantity'),
        ]);

        Stock::create([
            'contact_id' => auth()->user()->id,
            'quantity'   => $request->get('quantity'),
            'product_id' => $product->id,
        ]);

        return $this->sendResponse($product, 'Product Créé avec succès');
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
        return $this->sendResponse($product, 'Product Les informations ont été mises à jour');
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

        return $this->sendResponse($product, 'Product a été supprimé');
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
