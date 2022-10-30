<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdatePersonaRequest;
use App\Models\Ciudade;
use App\Models\Direccione;
use App\Models\Estado;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function __construct() {
        $this->middleware('can:personas.index')->only('index');
        $this->middleware('can:personas.create')->only('create', 'store');
        $this->middleware('can:personas.edit')->only('edit', 'update');
        $this->middleware('can:personas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personas = Persona::with('direccion.ciudade.estado')->get();

        return view('Adm.Personas.index', [
            'personas' => $personas,
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

        return view('Adm.Personas.create', [
            'estados' => $estados,
            'ciudades' => $ciudades,
            'sectores' => $sectores,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePersonaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();

            $persona = new Persona();
            $persona->cedula = $request->cedula;
            $persona->nacionalidad = $request->nacionalidad;
            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->telefono = $request->codigo.' '.$request->telefono;
            $persona->save();

            $log = new Log();
            $log->accion = "Nueva persona ".$persona->nombre." (".$persona->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            $selectCiudad = Ciudade::where('estado_id', $request->estado)->where('nombre', $request->ciudad)->get();
            if (isset($selectCiudad->id)) {
                $direccion = new Direccione();
                $direccion->sector = $request->sector;
                $direccion->direccioneable_id = $persona->id;
                $direccion->direccioneable_type = Persona::class;
                $direccion->ciudade_id = $selectCiudad->id;
                $direccion->save();    
                
                $log = new Log();
                $log->accion = "Nueva direccion (".$direccion->id.") para persona ".$persona->nombre." (".$persona->id.")";
                $log->user_id = Auth::user()->id;
                $log->save();
            } else {
                $ciudad = new Ciudade();
                $ciudad->nombre = $request->ciudad;
                $ciudad->estado_id = $request->estado;
                $ciudad->save();

                $direccion = new Direccione();
                $direccion->sector = $request->sector;
                $direccion->direccioneable_id = $persona->id;
                $direccion->direccioneable_type = Persona::class;
                $direccion->ciudade_id = $ciudad->id;
                $direccion->save();

                $log = new Log();
                $log->accion = 'Nueva ciudad '.$ciudad->nombre.' ('.$ciudad->id.') y nueva direccion '.'('.$direccion->id.') para persona '.$persona->nombre.' ('.$persona->id.')';
                $log->user_id = Auth::user()->id;
                $log->save();
            }

            DB::commit();

            return redirect()->route('personas.index');
            
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function show(Persona $persona)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function edit(Persona $persona)
    {
        $ciudades = Ciudade::all();
        $estados = Estado::all();
        $sectores = Direccione::all();
        $telefono = explode(" ", $persona->telefono);
        $code = $telefono[0];
        $numero = $telefono[1];

        return view('Adm.Personas.edit',[
            'persona' => $persona,
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
     * @param  \App\Http\Requests\UpdatePersonaRequest  $request
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePersonaRequest $request, Persona $persona)
    {
        try {
            DB::beginTransaction();

            $persona->nombre = $request->nombre;
            $persona->apellido = $request->apellido;
            $persona->telefono = $request->codigo." ".$request->telefono;
            $persona->save();

            $log = new Log();
            $log->accion = "Editar persona ".$persona->nombre." (".$persona->id.")";
            $log->user_id = Auth::user()->id;
            $log->save();

            $selectCiudad = Ciudade::where('estado_id', $request->estado)->where('nombre', $request->ciudad)->first();
            if (isset($selectCiudad->id)) {
                $persona->direccion->sector = $request->sector;
                $persona->direccion->ciudade_id = $selectCiudad->id;
                $persona->push();    
                
                $log = new Log();
                $log->accion = "Editar direccion (".$persona->direccion->id.") para persona ".$persona->nombre." (".$persona->id.")";
                $log->user_id = Auth::user()->id;
                $log->save();
            } else {
                $ciudad = new Ciudade();
                $ciudad->nombre = $request->ciudad;
                $ciudad->estado_id = $request->estado;
                $ciudad->save();

                $persona->direccion->sector = $request->sector;
                $persona->direccion->ciudade_id = $ciudad->id;
                $persona->push();

                $log = new Log();
                $log->accion = 'Editar ciudad '.$ciudad->nombre.' ('.$ciudad->id.') y direccion '.'('.$persona->direccion->id.') para persona '.$persona->nombre.' ('.$persona->id.')';
                $log->user_id = Auth::user()->id;
                $log->save();
            }

            DB::commit();

            return redirect()->route('personas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Persona  $persona
     * @return \Illuminate\Http\Response
     */
    public function destroy(Persona $persona)
    {
        try {
            DB::beginTransaction();

            $persona->direccion->delete();

            $persona->delete();

            $log = new Log();
            $log->accion = "Eliminar persona ".$persona->id."-".$persona->nombre;
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('personas.index');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
