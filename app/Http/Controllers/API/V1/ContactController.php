<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Users\ContactRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ContactController extends BaseController
{

    protected $Contact = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Contact $Contact)
    {
        $this->middleware('auth:api');
        $this->Contact = $Contact;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contacts = new ContactCollection($this->Contact->all());

        return $this->sendResponse($Contacts, 'Contact list');
    }
    public function list()
    {
        $Contacts = $this->Contact->latest()->get();

        return $this->sendResponse($Contacts, 'Contact list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $Contact = $this->Contact->create([
            'prenom'        => $request->get('prenom'),
            'nom'           => $request->get('nom'),
            'email'         => $request->get('email'),
            'password'      => Hash::make($request['password']),
            'adresse'       => $request->get('adresse'),
            'ville'         => $request->get('ville'),
            'phone'         => $request->get('phone'),
        ]);

        return $this->sendResponse($Contact, 'Contact Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $Contact
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = new ContactResource($this->Contact->findOrFail($id));

        return $this->sendResponse($product, 'Contact Details');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $Contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $Contact)
    {
        //
    }
    public function getStock(Contact $contact)
    {
        $response = [
            'success' => true,
            'data'    => new ProductCollection($contact->products),
            'message' => 'User Profile',
        ];
        return response()->json($response, 200);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $Contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, $id)
    {
        $Contact = $this->Contact->findOrFail($id);

        $Contact->update($request->all());

        return $this->sendResponse($Contact, 'Contact Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $Contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        $Contact = $this->Contact->findOrFail($id);

        $Contact->delete();

        return $this->sendResponse($Contact, 'Contact has been Deleted');
    }
}
