<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Http\Requests\StorePresupuestoRequest;
use App\Http\Requests\UpdatePresupuestoRequest;
use App\Models\Empresa;
use App\Models\Franquicia;
use App\Models\Log;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PresupuestoController extends Controller
{
    public function __construct() {
        $this->middleware('can:presupuestos.index')->only('index');
        $this->middleware('can:presupuestos.show')->only('show');
        $this->middleware('can:presupuestos.create')->only('create', 'store');
        $this->middleware('can:presupuestos.edit')->only('edit', 'update');
        $this->middleware('can:presupuestos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Franquicia $franquicia)
    {
        $presupuestos = Presupuesto::where('franquicia_id', $franquicia->id)->get();

        return view('Adm.Presupuestos.index', [
            'franquicia' => $franquicia,
            'presupuestos' => $presupuestos,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Franquicia $franquicia)
    {
        return view('Adm.Presupuestos.create', [
            'franquicia' => $franquicia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePresupuestoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Franquicia $franquicia, StorePresupuestoRequest $request)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;

                $presupuesto = new Presupuesto();
                $presupuesto->franquicia_id = $franquicia->id;
                $presupuesto->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $presupuesto->presupuestoable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $presupuesto->presupuestoable_type = Empresa::class;
                        break;
                }
                $presupuesto->presupuestoable_id = $request->cliente;
                $presupuesto->observaciones = $request->observaciones;
                $presupuesto->save();

                $franquicia->presupuesto += $franquicia->presupuesto;
                $franquicia->control_presupuesto += $franquicia->control_presupuesto;
                $franquicia->save();

                $presupuesto->slug = Str::slug('PR '.$franquicia->nombre.' '.str_pad($franquicia->presupuesto, 8, "0", STR_PAD_LEFT));
                $presupuesto->save();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $presupuesto->productos()->attach($item->id, [
                        'presupuesto_id' => $presupuesto->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $presupuesto->servicios()->attach($item->id, [
                        'presupuesto_id' => $presupuesto->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Crear nuevo presupuesto '.$presupuesto->slug.' para cliente ".$presupuesto->presupuestoable->nombre.' ('.$presupuesto->presupuestoable->id.' - id '.$presupuesto->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.presupuestos.index', $franquicia);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $th;
            }
        } else {
            return redirect()->back()
                        ->withErrors([
                            'cart' => 'El carrito esta vacio'
                        ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Presupuesto $presupuesto)
    {
        return view('Adm.Presupuestos.show', [
            'presupuesto' => $presupuesto,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuesto $presupuesto)
    {
        $franquicias = Franquicia::get();
        return view('Adm.Presupuestos.edit', [
            'presupuesto' => $presupuesto,
            'franquicias' => $franquicias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePresupuestoRequest  $request
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePresupuestoRequest $request, Presupuesto $presupuesto)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;
                if ($presupuesto->franquicia_id != $request->franquicia) {
                    $breadFranquicia = true;
                } else {
                    $breadFranquicia = false;
                }

                $presupuesto->franquicia_id = $request->franquicia;
                $presupuesto->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $presupuesto->presupuestoable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $presupuesto->presupuestoable_type = Empresa::class;
                        break;
                }
                $presupuesto->presupuestoable_id = $request->cliente;
                $presupuesto->observaciones = $request->observaciones;
                $presupuesto->save();

                $franquicia = Franquicia::find($request->franquicia);
                
                if ($breadFranquicia) {
                    $franquicia->presupuesto += $franquicia->presupuesto;
                    $franquicia->control_presupuesto += $franquicia->control_presupuesto;
                    $franquicia->save();
                }

                $presupuesto->slug = Str::slug('P '.$franquicia->nombre.' '.str_pad($franquicia->presupuesto, 8, "0", STR_PAD_LEFT));
                $presupuesto->save();

                $presupuesto->productos()->detach();
                $presupuesto->servicios()->detach();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $presupuesto->productos()->attach($item->id, [
                        'presupuesto_id' => $presupuesto->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $presupuesto->servicios()->attach($item->id, [
                        'presupuesto_id' => $presupuesto->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Editar Presupuesto '.$presupuesto->slug.' para cliente ".$presupuesto->presupuestoable->nombre.' ('.$presupuesto->presupuestoable->id.' - id '.$presupuesto->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.presupuestos.index', $franquicia);
            } catch (\Throwable $th) {
                DB::rollBack();
                return $th;
            }
        } else {
            return redirect()->back()
                        ->withErrors([
                            'cart' => 'El carrito esta vacio'
                        ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuesto $presupuesto)
    {
        try {
            DB::beginTransaction();

            $presupuesto->delete();

            $log = new Log();
            $log->accion = "Eliminar presupuesto '.$presupuesto->slug.' para cliente ".$presupuesto->presupuestoable->nombre.' ('.$presupuesto->presupuestoable->id.' - id '.$presupuesto->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.presupuestos.index', $presupuesto->franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
