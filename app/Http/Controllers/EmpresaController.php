<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Http\Requests\StoreEmpresaRequest;
use App\Http\Requests\UpdateEmpresaRequest;
use App\Models\Ciudade;
use App\Models\Direccione;
use App\Models\Estado;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function __construct() {
        $this->middleware('can:empresas.index')->only('index');
        $this->middleware('can:empresas.create')->only('create', 'store');
        $this->middleware('can:empresas.edit')->only('edit', 'update');
        $this->middleware('can:empresas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::with('direccion.ciudade.estado')->get();

        return view('Adm.Empresas.index', [
            'empresas' => $empresas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estados = Estado::all();
        $ciudades = Ciudade::all();
        $sectores = Direccione::all();

        return view('Adm.Empresas.create', [
            'estados' => $estados,
            'ciudades' => $ciudades,
            'sectores' => $sectores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmpresaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEmpresaRequest $request)
    {
        try {
            DB::beginTransaction();

            $empresa = new Empresa();
            $empresa->rif = $request->rif;
            $empresa->tipo = $request->tipo;
            $empresa->nombre = $request->nombre;
            $empresa->telefono = $request->codigo.' '.$request->telefono;
            $empresa->save();

            $log = new Log();
            $log->accion = "Nueva empresa ".$empresa->nombre." (".$empresa->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            $selectCiudad = Ciudade::where('estado_id', $request->estado)->where('nombre', $request->ciudad)->get();
            if (isset($selectCiudad->id)) {
                $direccion = new Direccione();
                $direccion->sector = $request->sector;
                $direccion->direccioneable_id = $empresa->id;
                $direccion->direccioneable_type = Empresa::class;
                $direccion->ciudade_id = $selectCiudad->id;
                $direccion->save();    
                
                $log = new Log();
                $log->accion = "Nueva direccion (".$direccion->id.") para empresa ".$empresa->nombre." (".$empresa->id.")";
                $log->user_id = Auth::user()->id;
                $log->save();
            } else {
                $ciudad = new Ciudade();
                $ciudad->nombre = $request->ciudad;
                $ciudad->estado_id = $request->estado;
                $ciudad->save();

                $direccion = new Direccione();
                $direccion->sector = $request->sector;
                $direccion->direccioneable_id = $empresa->id;
                $direccion->direccioneable_type = Empresa::class;
                $direccion->ciudade_id = $ciudad->id;
                $direccion->save();

                $log = new Log();
                $log->accion = 'Nueva ciudad '.$ciudad->nombre.' ('.$ciudad->id.') y nueva direccion '.'('.$direccion->id.') para empresa '.$empresa->nombre.' ('.$empresa->id.')';
                $log->user_id = Auth::user()->id;
                $log->save();
            }

            DB::commit();

            return redirect()->route('empresas.index');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function edit(Empresa $empresa)
    {
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $sectores = Direccione::all();
        $telefono = explode(" ", $empresa->telefono);
        $code = $telefono[0];
        $numero = $telefono[1];

        return view('Adm.Empresas.edit', [
            'empresa' => $empresa,
            'ciudades' => $ciudades,
            'estados' => $estados,
            'sectores' => $sectores,
            'code' => $code,
            'numero' => $numero,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmpresaRequest  $request
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEmpresaRequest $request, Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $empresa->nombre = $request->nombre;
            $empresa->telefono = $request->codigo.' '.$request->telefono;
            $empresa->save();

            $log = new Log();
            $log->accion = "Editar empresa ".$empresa->nombre." (".$empresa->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            $selectCiudad = Ciudade::where('estado_id', $request->estado)->where('nombre', $request->ciudad)->first();
            if (isset($selectCiudad->id)) {
                $empresa->direccion->sector = $request->sector;
                $empresa->direccion->ciudade_id = $selectCiudad->id;
                $empresa->push();    
                
                $log = new Log();
                $log->accion = "Editar direccion (".$empresa->direccion->id.") para empresa ".$empresa->nombre." (".$empresa->id.")";
                $log->user_id = Auth::user()->id;
                $log->save();
            } else {
                $ciudad = new Ciudade();
                $ciudad->nombre = $request->ciudad;
                $ciudad->estado_id = $request->estado;
                $ciudad->save();

                $empresa->direccion->sector = $request->sector;
                $empresa->direccion->ciudade_id = $ciudad->id;
                $empresa->push();

                $log = new Log();
                $log->accion = 'Editar ciudad '.$ciudad->nombre.' ('.$ciudad->id.') y direccion '.'('.$empresa->direccion->id.') para empresa '.$empresa->nombre.' ('.$empresa->id.')';
                $log->user_id = Auth::user()->id;
                $log->save();
            }

            DB::commit();

            return redirect()->route('empresas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $empresa->direccion->delete();

            $empresa->delete();

            $log = new Log();
            $log->accion = "Eliminar empresa ".$empresa->id."-".$empresa->nombre;
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('empresas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
