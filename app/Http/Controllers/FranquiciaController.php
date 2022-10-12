<?php

namespace App\Http\Controllers;

use App\Models\Franquicia;
use App\Http\Requests\StoreFranquiciaRequest;
use App\Http\Requests\UpdateFranquiciaRequest;

class FranquiciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreFranquiciaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFranquiciaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Franquicia  $franquicia
     * @return \Illuminate\Http\Response
     */
    public function show(Franquicia $franquicia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Franquicia  $franquicia
     * @return \Illuminate\Http\Response
     */
    public function edit(Franquicia $franquicia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFranquiciaRequest  $request
     * @param  \App\Models\Franquicia  $franquicia
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFranquiciaRequest $request, Franquicia $franquicia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Franquicia  $franquicia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Franquicia $franquicia)
    {
        //
    }
}
