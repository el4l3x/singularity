<?php

namespace App\Http\Livewire\Adm;

use Livewire\Component;

class CreateEmpresa extends Component
{
    public $rif;
    public $error;
    public $readonly = false;
    public $nombre;
    public $load = "Buscar";

    public function buscarci()
    {
        $this->load = "Buscando...";
        try {
            $client = new Client();
            $crawler = $client->request('GET', 'http://www.cne.gob.ve/web/registro_electoral/ce.php?nacionalidad=V&cedula='.$this->cedula);

            $texto = $crawler->text();
            $Condi = strlen($texto);
            
            if ($Condi < 720) {
                $nombre = $crawler->filter('td > b')->eq(2)->text();

                $nombres = explode(" ", $nombre);

                switch (count($nombres)) {
                    case 2:
                        $this->nombre = $nombres[0];
                        $this->apellido = $nombres[1];
                        $this->errorci = null;
                        $this->readonly = true;
                        break;

                    case 3:
                        $this->nombre = $nombres[0].' '.$nombres[1];
                        $this->apellido = $nombres[2];
                        $this->errorci = null;
                        $this->readonly = true;
                        break;
                    
                    case 4:
                        $this->nombre = $nombres[0].' '.$nombres[1];
                        $this->apellido = $nombres[2].' '.$nombres[3];
                        $this->errorci = null;
                        $this->readonly = true;
                        break;

                    case 5:
                        $this->nombre = $nombres[0].' '.$nombres[1].' '.$nombres[2];
                        $this->apellido = $nombres[3].' '.$nombres[4];
                        $this->errorci = null;
                        $this->readonly = true;
                        break;

                    default:
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = "Error de seguimiento.";
                        $this->readonly = false;
                        break;
                }

                $this->load = "Buscar";
                
            }else {
                switch ($Condi) {
                    case '720':                        
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = 'No Registrado';
                        $this->readonly = false;                        

                    case '1184':                        
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = 'Ha Fallecido'.$texto;
                        $this->readonly = false;                        

                    case '1185':                        
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = 'Ha Fallecido'.$texto;
                        $this->readonly = false;                        

                    case '663':                        
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = 'Ha Fallecido'.$texto;
                        $this->readonly = false;                        

                    default:
                        $this->nombre = null;
                        $this->apellido = null;
                        $this->errorci = 'Error Inesperado'.$texto;
                        $this->readonly = false;
                }

                $this->load = "Buscar";
            }
        } catch (\Throwable $th) {
            $this->nombre = null;
            $this->apellido = null;
            $this->errorci = "No encontramos registros de esta C.I";
            $this->readonly = false;

            $this->load = "Buscar";
        }
    }

    public function render()
    {
        return view('livewire.adm.create-empresa');
    }
}
