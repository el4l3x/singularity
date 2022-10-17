<?php

namespace App\Http\Controllers;

use App\Models\Cobro;
use App\Http\Requests\StoreCobroRequest;
use App\Http\Requests\UpdateCobroRequest;

class CobroController extends Controller
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
     * @param  \App\Http\Requests\StoreCobroRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCobroRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function show(Cobro $cobro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function edit(Cobro $cobro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCobroRequest  $request
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCobroRequest $request, Cobro $cobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobro $cobro)
    {
        //
    }
}
