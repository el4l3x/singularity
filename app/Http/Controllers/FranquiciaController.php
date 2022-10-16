<?php

namespace App\Http\Controllers;

use App\Models\Franquicia;
use App\Http\Requests\StoreFranquiciaRequest;
use App\Http\Requests\UpdateFranquiciaRequest;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FranquiciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $franquicias = Franquicia::all();
        return view("Adm.Franquicias.index", [
            'franquicias' => $franquicias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Adm.Franquicias.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFranquiciaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFranquiciaRequest $request)
    {
        try {
            DB::beginTransaction();

            $franquicia = new Franquicia();

            $franquicia->nombre = $request->nombre;
            $franquicia->actividad = $request->actividad;
            $franquicia->rif = $request->rif;

            $franquicia->save();

            $log = new Log();

            $log->user_id = Auth::user()->id;
            $log->accion = "Crear nueva franquicia";

            $log->save();

            DB::commit();

            return redirect()->route('franquicias.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
        return view("Adm.Franquicias.edit", [
            'franquicia' => $franquicia,
        ]);
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
        try {
            DB::beginTransaction();

            $franquicia->nombre = $request->nombre;
            $franquicia->actividad = $request->actividad;
            $franquicia->rif = $request->rif;
            $franquicia->save();

            $log = new Log();
            $log->accion = "Editar franquicia ".$franquicia->id;
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Franquicia  $franquicia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Franquicia $franquicia)
    {
        try {
            DB::beginTransaction();

            $franquicia->delete();

            $log = new Log();
            $log->accion = "Eliminar franquicia ".$franquicia->id."-".$franquicia->nombre;
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
