<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Http\Requests\StoreFacturaRequest;
use App\Http\Requests\UpdateFacturaRequest;
use App\Models\Empresa;
use App\Models\Franquicia;
use App\Models\Log;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FacturaController extends Controller
{
    public function __construct() {
        $this->middleware('can:facturas.index')->only('index');
        $this->middleware('can:facturas.create')->only('create', 'store');
        $this->middleware('can:facturas.show')->only('show');
        $this->middleware('can:facturas.edit')->only('edit', 'update');
        $this->middleware('can:facturas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Franquicia $franquicia)
    {
        $facturas = Factura::where('franquicia_id', $franquicia->id)->get();

        return view('Adm.Facturas.index', [
            'franquicia' => $franquicia,
            'facturas' => $facturas,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Franquicia $franquicia)
    {
        return view('Adm.Facturas.create', [
            'franquicia' => $franquicia,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFacturaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Franquicia $franquicia, StoreFacturaRequest $request)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;

                $factura = new Factura();
                $factura->franquicia_id = $franquicia->id;
                $factura->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $factura->facturable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $factura->facturable_type = Empresa::class;
                        break;
                }
                $factura->facturable_id = $request->cliente;
                $factura->observaciones = $request->observaciones;
                $factura->save();

                $franquicia->factura += $franquicia->factura;
                $franquicia->control_factura += $franquicia->control_factura;
                $franquicia->save();

                $factura->slug = Str::slug('FC '.$franquicia->nombre.' '.str_pad($franquicia->factura, 8, "0", STR_PAD_LEFT));
                $factura->save();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $factura->productos()->attach($item->id, [
                        'factura_id' => $factura->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $factura->servicios()->attach($item->id, [
                        'factura_id' => $factura->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Crear nueva factura '.$factura->slug.' para cliente ".$factura->facturable->nombre.' ('.$factura->facturable->id.' - id '.$factura->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.facturas.index', $franquicia);
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
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function show(Factura $factura)
    {
        return view('Adm.Facturas.show', [
            'factura' => $factura,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function edit(Factura $factura)
    {
        $franquicias = Franquicia::get();
        return view('Adm.Facturas.edit', [
            'factura' => $factura,
            'franquicias' => $franquicias,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFacturaRequest  $request
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFacturaRequest $request, Factura $factura)
    {
        $idCartS = "s-".Auth::user()->id;
        $idCartP = "p-".Auth::user()->id;
        if (Cart::session($idCartS)->getContent()->count() > 0 || Cart::session($idCartP)->getContent()->count() > 0) {
            try {
                DB::beginTransaction();

                $totalP = Cart::session($idCartP)->getTotal();
                $totalS = Cart::session($idCartS)->getTotal();
                $total = $totalP+$totalS;
                if ($factura->franquicia_id != $request->franquicia) {
                    $breadFranquicia = true;
                } else {
                    $breadFranquicia = false;
                }

                $factura->franquicia_id = $request->franquicia;
                $factura->total = $total;
                switch ($request->tipo) {
                    case 'p':
                        $factura->facturable_type = Persona::class;
                        break;
                    
                    case 'e':
                        $factura->facturable_type = Empresa::class;
                        break;
                }
                $factura->facturable_id = $request->cliente;
                $factura->observaciones = $request->observaciones;
                $factura->save();

                $franquicia = Franquicia::find($request->franquicia);
                
                if ($breadFranquicia) {
                    $franquicia->factura += $franquicia->factura;
                    $franquicia->control_factura += $franquicia->control_factura;
                    $franquicia->save();
                }

                $factura->slug = Str::slug('FC '.$franquicia->nombre.' '.str_pad($franquicia->factura, 8, "0", STR_PAD_LEFT));
                $factura->save();

                $factura->productos()->detach();
                $factura->servicios()->detach();
                
                foreach (Cart::session($idCartP)->getContent() as $item) {                    
                    $factura->productos()->attach($item->id, [
                        'factura_id' => $factura->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                foreach (Cart::session($idCartS)->getContent() as $item) {                    
                    $factura->servicios()->attach($item->id, [
                        'factura_id' => $factura->id,
                        'cantidad' => $item->quantity,
                        'precio' => $item->price,
                        'descripcion' => $item->attributes->descripcion,
                    ]);
                };
                
                $log = new Log();
                $log->user_id = Auth::user()->id;
                $log->accion = "Editar factura '.$factura->slug.' para cliente ".$factura->facturable->nombre.' ('.$factura->facturable->id.' - id '.$factura->id.')';
                $log->save();
                
                DB::commit();

                Cart::session($idCartP)->clear();
                Cart::session($idCartS)->clear();
                
                return redirect()->route('franquicias.facturas.index', $franquicia);
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
     * @param  \App\Models\Factura  $factura
     * @return \Illuminate\Http\Response
     */
    public function destroy(Factura $factura)
    {
        try {
            DB::beginTransaction();

            $factura->delete();

            $log = new Log();
            $log->accion = "Eliminar factura '.$factura->slug.' para cliente ".$factura->facturable->nombre.' ('.$factura->facturable->id.' - id '.$factura->id.')';
            $log->user_id = Auth::user()->id;
            $log->save();

            DB::commit();

            return redirect()->route('franquicias.facturas.index', $factura->franquicia);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
