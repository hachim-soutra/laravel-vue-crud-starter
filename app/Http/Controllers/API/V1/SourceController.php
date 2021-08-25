<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController;
use App\Http\Resources\SourceResource;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function App\Helpers\unique_str;

class SourceController extends BaseController
{
    protected $Source = '';

    public function __construct(Source $Source)
    {
        $this->middleware('auth:api');
        $this->Source = $Source;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Sources = $this->Source->allSource();
        return $this->sendResponse($Sources, 'Source list');
    }

    public function list()
    {
        $sources = Source::where('status', 'active')->get();
        return $this->sendResponse($sources, 'Source list');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $uniqueStr = Str::random(12);
        while (Source::where('token', $uniqueStr)->exists()) {
            $uniqueStr = Str::random(12);
        }
        $Source = $this->Source->create([
            'name'      => $request->name,
            'type'      => $request->type,
            'status'    => 'active',
            'token'     => $uniqueStr
        ]);
        return $this->sendResponse($Source, 'Source Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Source  $Source
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Source = $this->Source->findOrFail($id);
        return $this->sendResponse(new SourceResource($Source), 'Source Details');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Source  $Source
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Source = $this->Source->findOrFail($id);
        $Source->update($request->all());
        return $this->sendResponse($Source, 'Source Information has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Source  $Source
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $Source = $this->Source->findOrFail($id);
        $Source->delete();
        return $this->sendResponse($Source, 'Source has been Deleted');
    }
}
