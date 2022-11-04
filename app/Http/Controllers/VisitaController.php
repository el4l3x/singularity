<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Http\Requests\StoreVisitaRequest;
use App\Http\Requests\UpdateVisitaRequest;
use App\Models\Empresa;
use App\Models\Franquicia;
use App\Models\Log;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VisitaController extends Controller
{
    public function __construct() {
        $this->middleware('can:visitas.index')->only('index');
        $this->middleware('can:visitas.show')->only('show');
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
        $visitas = Visita::where('franquicia_id', $franquicia->id)->get();

        return view('Adm.Visitas.index', [
            'franquicia' => $franquicia,
            'visitas' => $visitas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Franquicia $franquicia)
    {
        $personas = Persona::get();
        $empresas = Empresa::get();
        $productos = Producto::get();
        $servicios = Servicio::get();

        return view('Adm.Visitas.create', [
            'franquicia' => $franquicia,
            'personas' => $personas,
            'empresas' => $empresas,
            'productos' => $productos,
            'servicios' => $servicios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Franquicia $franquicia, StoreVisitaRequest $request)
    {
        try {
            DB::beginTransaction();

            $visita = new Visita();
            $visita->entrada = $request->entrada;
            $visita->salida = $request->salida;
            $visita->slug = Str::slug(date('d-m-Y').' '.$franquicia->nombre);
            $visita->descripcion = $request->descripcion;
            switch ($request->tipo) {
                case 'p':
                    $visita->visitable_type = Persona::class;
                    break;
                
                case 'e':
                    $visita->visitable_type = Empresa::class;
                    break;
            }
            $visita->visitable_id = $request->cliente;
            $visita->franquicia_id = $franquicia->id;
            $visita->save();

            $visita->productos()->syncWithPivotValues($request->productos, [
                'visita_id' => $visita->id,
            ]);

            $visita->servicios()->syncWithPivotValues($request->servicios, [
                'visita_id' => $visita->id,
            ]);

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = "Crear nueva visita '.$visita->slug.' para cliente ".$visita->visitable->nombre.' ('.$visita->visitable->id.' - id '.$visita->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.visitas.index', $franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function show(Visita $visita)
    {
        return view('Adm.Visitas.show', [
            'visita' => $visita,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function edit(Visita $visita)
    {
        $personas = Persona::get();
        $empresas = Empresa::get();
        $productos = Producto::get();
        $servicios = Servicio::get();

        return view('Adm.Visitas.edit', [
            'visita' => $visita,
            'personas' => $personas,
            'empresas' => $empresas,
            'productos' => $productos,
            'servicios' => $servicios,
        ]);
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
        try {
            DB::beginTransaction();

            $visita->entrada = $request->entrada;
            $visita->salida = $request->salida;
            $visita->descripcion = $request->descripcion;
            $visita->save();

            $visita->productos()->syncWithPivotValues($request->productos, [
                'visita_id' => $visita->id,
            ]);

            $visita->servicios()->syncWithPivotValues($request->servicios, [
                'visita_id' => $visita->id,
            ]);

            $log = new Log();
            $log->user_id = Auth::user()->id;
            $log->accion = "Editar visita '.$visita->slug.' para cliente ".$visita->visitable->nombre.' ('.$visita->visitable->id.' - id '.$visita->id.')';
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.visitas.index', $visita->franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visita  $visita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita)
    {
        try {
            DB::beginTransaction();

            $visita->delete();

            $log = new Log();
            $log->accion = "Eliminas visita '.$visita->slug.' para cliente ".$visita->visitable->nombre.' ('.$visita->visitable->id.' - id '.$visita->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.visitas.index', $visita->franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
