<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Http\Requests\StoreEntregaRequest;
use App\Http\Requests\UpdateEntregaRequest;
use App\Models\Empresa;
use App\Models\Franquicia;
use App\Models\Log;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\Servicio;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EntregaController extends Controller
{
    public function __construct() {
        $this->middleware('can:entregas.index')->only('index');
        $this->middleware('can:entregas.show')->only('show');
        $this->middleware('can:entregas.create')->only('create', 'store');
        $this->middleware('can:entregas.edit')->only('edit', 'update');
        $this->middleware('can:entregas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Franquicia $franquicia)
    {
        $entregas = Entrega::where('franquicia_id', $franquicia->id)->get();

        return view('Adm.Entregas.index', [
            'franquicia' => $franquicia,
            'entregas' => $entregas,
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

        return view('Adm.Entregas.create', [
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
     * @param  \App\Http\Requests\StoreEntregaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Franquicia $franquicia, StoreEntregaRequest $request)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;

                $entrega = new Entrega();
                $entrega->franquicia_id = $franquicia->id;
                $entrega->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $entrega->entregable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $entrega->entregable_type = Empresa::class;
                        break;
                }
                $entrega->entregable_id = $request->cliente;
                $entrega->observaciones = $request->observaciones;
                $entrega->save();

                $franquicia->entrega += $franquicia->entrega;
                $franquicia->control_entrega += $franquicia->control_entrega;
                $franquicia->save();

                $entrega->slug = Str::slug('NE '.$franquicia->nombre.' '.str_pad($franquicia->entrega, 8, "0", STR_PAD_LEFT));
                $entrega->save();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $entrega->productos()->attach($item->id, [
                        'entrega_id' => $entrega->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $entrega->servicios()->attach($item->id, [
                        'entrega_id' => $entrega->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Crear nueva entrega '.$entrega->slug.' para cliente ".$entrega->entregable->nombre.' ('.$entrega->entregable->id.' - id '.$entrega->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.entregas.index', $franquicia);
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
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function show(Entrega $entrega)
    {
        return view('Adm.Entregas.show', [
            'entrega' => $entrega,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrega $entrega)
    {
        $franquicias = Franquicia::get();
        return view('Adm.Entregas.edit', [
            'entrega' => $entrega,
            'franquicias' => $franquicias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEntregaRequest  $request
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntregaRequest $request, Entrega $entrega)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;
                if ($entrega->franquicia_id != $request->franquicia) {
                    $breadFranquicia = true;
                } else {
                    $breadFranquicia = false;
                }

                $entrega->franquicia_id = $request->franquicia;
                $entrega->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $entrega->entregable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $entrega->entregable_type = Empresa::class;
                        break;
                }
                $entrega->entregable_id = $request->cliente;
                $entrega->observaciones = $request->observaciones;
                $entrega->save();

                $franquicia = Franquicia::find($request->franquicia);
                
                if ($breadFranquicia) {
                    $franquicia->entrega += $franquicia->entrega;
                    $franquicia->control_entrega += $franquicia->control_entrega;
                    $franquicia->save();
                }

                $entrega->slug = Str::slug('NE '.$franquicia->nombre.' '.str_pad($franquicia->entrega, 8, "0", STR_PAD_LEFT));
                $entrega->save();

                $entrega->productos()->detach();
                $entrega->servicios()->detach();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $entrega->productos()->attach($item->id, [
                        'entrega_id' => $entrega->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $entrega->servicios()->attach($item->id, [
                        'entrega_id' => $entrega->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Editar nota de entrega '.$entrega->slug.' para cliente ".$entrega->entregable->nombre.' ('.$entrega->entregable->id.' - id '.$entrega->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.entregas.index', $franquicia);
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
     * @param  \App\Models\Entrega  $entrega
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrega $entrega)
    {
        try {
            DB::beginTransaction();

            $entrega->delete();

            $log = new Log();
            $log->accion = "Eliminar entrega '.$entrega->slug.' para cliente ".$entrega->entregable->nombre.' ('.$entrega->entregable->id.' - id '.$entrega->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.entregas.index', $entrega->franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
