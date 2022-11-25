<?php

namespace App\Http\Livewire\Exp;

use App\Models\Empresa;
use App\Models\Persona;
use Livewire\Component;

class SelectCliente extends Component
{
    public $datas;
    public $personas;
    public $empresas;
    public $tipo;
    public $observaciones;
    public $cliente;
    public $clienteT;
    public $selectC;

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

    public function mount()
    {
        $this->personas = Persona::get();
        $this->empresas = Empresa::get();

        if ($this->clienteT == 'App\Models\Persona') {
            $this->datas = $this->personas;
            $this->selectC = 'p';
        } else {
            $this->datas = $this->empresas;
            $this->selectC = 'e';
        }
        
    }

    public function render()
    {
        return view('livewire.exp.select-cliente');
    }
}
