<?php

namespace App\Http\Controllers;

use App\Models\Direccione;
use App\Http\Requests\StoreDireccioneRequest;
use App\Http\Requests\UpdateDireccioneRequest;

class DireccioneController extends Controller
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
     * @param  \App\Http\Requests\StoreDireccioneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDireccioneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Direccione  $direccione
     * @return \Illuminate\Http\Response
     */
    public function show(Direccione $direccione)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Direccione  $direccione
     * @return \Illuminate\Http\Response
     */
    public function edit(Direccione $direccione)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDireccioneRequest  $request
     * @param  \App\Models\Direccione  $direccione
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDireccioneRequest $request, Direccione $direccione)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Direccione  $direccione
     * @return \Illuminate\Http\Response
     */
    public function destroy(Direccione $direccione)
    {
        //
    }
}
