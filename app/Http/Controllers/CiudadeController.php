<?php

namespace App\Http\Controllers;

use App\Models\Ciudade;
use App\Http\Requests\StoreCiudadeRequest;
use App\Http\Requests\UpdateCiudadeRequest;

class CiudadeController extends Controller
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
     * @param  \App\Http\Requests\StoreCiudadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCiudadeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function show(Ciudade $ciudade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function edit(Ciudade $ciudade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCiudadeRequest  $request
     * @param  \App\Models\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCiudadeRequest $request, Ciudade $ciudade)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ciudade  $ciudade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ciudade $ciudade)
    {
        //
    }
}
