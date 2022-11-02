<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Http\Requests\StoreServicioRequest;
use App\Http\Requests\UpdateServicioRequest;
use App\Models\Log;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServicioController extends Controller
{
    public function __construct() {
        $this->middleware('can:servicios.index')->only('index');
        $this->middleware('can:servicios.create')->only('create', 'store');
        $this->middleware('can:servicios.edit')->only('edit', 'update');
        $this->middleware('can:servicios.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::get();

        return view('Adm.Servicios.index', [
            'servicios' => $servicios,
        ]);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::get();

        return view('Adm.Servicios.create', [
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreServicioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicioRequest $request)
    {
        try {
            DB::beginTransaction();

            $servicio = new Servicio();
            $servicio->nombre = $request->nombre;
            $servicio->precio = $request->precio;
            $servicio->save();

            $servicio->tags()->syncWithPivotValues($request->etiquetas, [
                'taggable_id' => $servicio->id,
                'taggable_type' => Servicio::class,
            ]);

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = "Crear nuevo servicio ".$servicio->nombre.' ('.$servicio->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('servicios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit(Servicio $servicio)
    {
        $tags = Tag::get();
        return view('Adm.Servicios.edit', [
            'servicio' => $servicio,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateServicioRequest  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServicioRequest $request, Servicio $servicio)
    {
        try {
            DB::beginTransaction();

            $servicio->nombre = $request->nombre;
            $servicio->precio = $request->precio;
            $servicio->save();

            $servicio->tags()->syncWithPivotValues($request->etiquetas, [
                'taggable_id' => $servicio->id,
                'taggable_type' => Servicio::class,
            ]);

            $log = new Log();
            $log->accion = 'Editar servicio '.$servicio->nombre.' ('.$servicio->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('servicios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        try {
            DB::beginTransaction();

            $servicio->delete();

            $log = new Log();
            $log->accion = "Eliminar producto ".$servicio->nombre.' ('.$servicio->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('servicios.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
