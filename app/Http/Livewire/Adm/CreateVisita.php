<?php

namespace App\Http\Livewire\Adm;

use Livewire\Component;

class CreateVisita extends Component
{
    public $personas;
    public $empresas;
    public $tipo;
    public $datas;

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
        $this->datas = $this->personas;
    }

    public function render()
    {
        return view('livewire.adm.create-visita');
    }
}
