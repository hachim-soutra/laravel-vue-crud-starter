<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ReturnColis;
use Illuminate\Http\Request;

class ReturnColisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ReturnColis::whereHas('colis', function ($colis) {
            $colis->user_id == auth()->user()->id;
        })->paginate(15);
        $res['data'] = $data;
        $res['msg']  = "success";
        return response($res, 200);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturnColis  $returnColis
     * @return \Illuminate\Http\Response
     */
    public function show(ReturnColis $returnColis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturnColis  $returnColis
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturnColis $returnColis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReturnColis  $returnColis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturnColis $returnColis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturnColis  $returnColis
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturnColis $returnColis)
    {
        //
    }
}
