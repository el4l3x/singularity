<?php

namespace App\Http\Livewire\Adm;

use App\Models\Producto;
use App\Models\Servicio;
use Livewire\Component;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;

class CreateEntrega extends Component
{
    public $personas;
    public $empresas;
    public $datas;
    public $tipo;
    public $productos;
    public $servicios;
    public $productoId = false;
    public $errorProducto = "null";
    public $servicioId = false;
    public $errorServicio = "null";
    public $totalP = 0;
    public $totalS = 0;
    public $total = 0;

    public function buscar()
    {
        switch ($this->tipo) {
            case 'e':
                $this->datas = $this->empresas;
                break;

            case 'p':
                $this->datas = $this->personas;
                break;
        }
    }

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
        $this->datas = $this->personas;
    }
    
    public function render()
    {
        $idCartP = "p-".Auth::user()->id;
        $carritoP = Cart::session($idCartP)->getContent();
        
        $idCartS = "s-".Auth::user()->id;
        $carritoS = Cart::session($idCartS)->getContent();

        $this->total = $this->totalP+$this->totalS;
        return view('livewire.adm.create-entrega', [
            'carritoP' => $carritoP,
            'carritoS' => $carritoS,
        ]);
    }
}
