<?php

namespace App\Http\Livewire\Exp;

use App\Models\Producto;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CartVenta extends Component
{
    public $productos;
    public $servicios;
    public $productoId = false;
    public $errorProducto = "null";
    public $servicioId = false;
    public $errorServicio = "null";
    public $totalP = 0;
    public $totalS = 0;
    public $total = 0;
    public $data = false;

    public function addProducto()
    {
        if ($this->productoId && !empty($this->productoId)) {
            $producto = Producto::find($this->productoId);

            $idCart = "p-".Auth::user()->id;

            if (Cart::session($idCart)->get($producto->id)) {
                Cart::session($idCart)->update($producto->id, array(
                    'quantity' => 1,
                ));
            } else {
                Cart::session($idCart)->add(array(
                    'id' => $producto->id,
                    'name' => $producto->nombre,
                    'price' => $producto->precio,
                    'quantity' => 1,
                    'attributes' => array(),
                    'associatedModel' => Producto::class,
                ));
            }

            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function addServicio()
    {
        if ($this->servicioId && !empty($this->servicioId)) {
            $servicio = Servicio::find($this->servicioId);

            $idCart = "s-".Auth::user()->id;

            if (Cart::session($idCart)->get($servicio->id)) {
                Cart::session($idCart)->update($servicio->id, array(
                    'quantity' => 1,
                ));
            } else {
                Cart::session($idCart)->add(array(
                    'id' => $servicio->id,
                    'name' => $servicio->nombre,
                    'price' => $servicio->precio,
                    'quantity' => 1,
                    'attributes' => array(),
                    'associatedModel' => Servicio::class,
                ));
            }

            $this->totalS = Cart::session($idCart)->getTotal();
        }
    }

    public function updatePriceP($idProducto, $precio = 1)
    {
        $idCart = "p-".Auth::user()->id;
        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->update($idProducto, array(
                'price' => $precio,
              ));
            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function updatePriceS($idServicio, $precio = 1)
    {
        $idCart = "s-".Auth::user()->id;
        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->update($idServicio, array(
                'price' => $precio,
              ));
            $this->totalS = Cart::session($idCart)->getTotal();              
        }
    }

    public function updateCantidadP($idProducto, $cantidad = 1)
    {
        $idCart = "p-".Auth::user()->id;
        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->update($idProducto, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cantidad
                ),
            ));
            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function updateCantidadS($idServicio, $cantidad = 1)
    {
        $idCart = "s-".Auth::user()->id;
        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->update($idServicio, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $cantidad
                ),
            ));
            $this->totalS = Cart::session($idCart)->getTotal();
        }
    }
    
    public function updateDescripcionP($idProducto, $descripcion = "")
    {
        $idCart = "p-".Auth::user()->id;
        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->update($idProducto, array(
                'attributes' => array(
                    'descripcion' => $descripcion,
                )
            ));              
        }
    }
    
    public function updateDescripcionS($idServicio, $descripcion = "")
    {
        $idCart = "s-".Auth::user()->id;
        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->update($idServicio, array(
                'attributes' => array(
                    'descripcion' => $descripcion,
                )
            ));              
        }
    }

    public function plusP($idProducto)
    {
        $idCart = "p-".Auth::user()->id;

        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->update($idProducto, array(
                'quantity' => 1,
            ));
            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function plusS($idServicio)
    {
        $idCart = "s-".Auth::user()->id;

        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->update($idServicio, array(
                'quantity' => 1,
            ));
            $this->totalS = Cart::session($idCart)->getTotal();
        }
    }

    public function minusP($idProducto)
    {
        $idCart = "p-".Auth::user()->id;

        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->update($idProducto, array(
                'quantity' => -1,
            ));
            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function minusS($idServicio)
    {
        $idCart = "s-".Auth::user()->id;

        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->update($idServicio, array(
                'quantity' => -1,
            ));
            $this->totalS = Cart::session($idCart)->getTotal();
        }
    }
    
    public function removeP($idProducto)
    {
        $idCart = "p-".Auth::user()->id;

        if (Cart::session($idCart)->get($idProducto)) {
            Cart::session($idCart)->remove($idProducto);
            $this->totalP = Cart::session($idCart)->getTotal();
        }
    }
    
    public function removeS($idServicio)
    {
        $idCart = "s-".Auth::user()->id;

        if (Cart::session($idCart)->get($idServicio)) {
            Cart::session($idCart)->remove($idServicio);
            $this->totalS = Cart::session($idCart)->getTotal();
        }
    }

    public function mount()
    {
        
        $idCartP = "p-".Auth::user()->id;
        Cart::session($idCartP)->clear();

        $idCartS = "s-".Auth::user()->id;
        Cart::session($idCartS)->clear();

        if ($this->data != false) {

            foreach ($this->data->productos as $item) {
                Cart::session($idCartP)->add(array(
                    'id' => $item->id,
                    'name' => $item->nombre,
                    'price' => $item->pivot->precio,
                    'quantity' => $item->pivot->cantidad,
                    'attributes' => array(
                        'descripcion' => $item->pivot->descripcion,
                    ),
                    'associatedModel' => Producto::class,
                ));    
            }            

            foreach ($this->data->servicios as $item) {
                Cart::session($idCartS)->add(array(
                    'id' => $item->id,
                    'name' => $item->nombre,
                    'price' => $item->pivot->precio,
                    'quantity' => $item->pivot->cantidad,
                    'attributes' => array(
                        'descripcion' => $item->pivot->descripcion,
                    ),
                    'associatedModel' => Servicio::class,
                ));    
            }

        }
        
        $this->totalP = Cart::session($idCartP)->getTotal();
        $this->totalS = Cart::session($idCartS)->getTotal();
        
        $this->productos = Producto::get();
        $this->servicios = Servicio::get();
    }

    public function render()
    {
        $idCartP = "p-".Auth::user()->id;
        $carritoP = Cart::session($idCartP)->getContent();
        
        $idCartS = "s-".Auth::user()->id;
        $carritoS = Cart::session($idCartS)->getContent();

        $this->total = $this->totalP+$this->totalS;

        return view('livewire.exp.cart-venta', [
            'carritoP' => $carritoP,
            'carritoS' => $carritoS,
        ]);
    }
}
