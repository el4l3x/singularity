<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Http\Requests\StoreVisitaRequest;
use App\Http\Requests\UpdateVisitaRequest;
use App\Models\Franquicia;

class VisitaController extends Controller
{
    public function __construct() {
        $this->middleware('can:visitas.index')->only('index');
        $this->middleware('can:visitas.create')->only('create', 'store');
        $this->middleware('can:visitas.edit')->only('edit', 'update');
        $this->middleware('can:visitas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Franquicia $franquicia)
    {
        return view('Adm.Visitas.index', [
            'franquicia' => $franquicia,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Franquicia $franquicia)
    {
        return view('Adm.Visitas.create', [
            'franquicia' => $franquicia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function edit(Visita $visita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitaRequest  $request
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitaRequest $request, Visita $visita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        //
    }
}
