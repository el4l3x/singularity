<?php

namespace App\Http\Livewire\Exp;

use Livewire\Component;
use App\Models\Producto;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class SelectProducto extends Component
{
    public $productos;
    public $productoName;
    public $productoId = null;
    public $errorP;
    public $isInvalid = false;

    public function addProducto()
    {
        $producto = Producto::find($this->productoId)->first();

        if ($producto == null || empty($producto)) {
            $this->errorP = "El producto no exite";
        } else {
            if ($this->InCart($producto->id)) {
                $this->increaseQty($producto->id);
                return;
            }

            Cart::add($producto->id, $producto->nombre, $producto->precio, 1);
            /* $this->total = Cart::getTotal(); */
        }
    }

    public function render()
    {
        return view('livewire.exp.select-producto');
    }
}
