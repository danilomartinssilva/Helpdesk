<?php
namespace Admin\Model;

class Cadpri
{
    public $id_cadpri,$desc_cadpri,$componente_cadpri,$tempo_cadpri;
    public function exchangeArray($data){
    	
        $this->id_cadpri = (isset($data['id_cadpri'])) ? (int) $data['id_cadpri']:null;
        $this->desc_cadpri = (isset($data['desc_cadpri'])) ? $data['desc_cadpri']:null;
        $this->componente_cadpri = (isset($data['componente_cadpri'])) ? $data['componente_cadpri']:null;
        $this->tempo_cadpri = (isset($data['tempo_cadpri'])) ? $data['tempo_cadpri']:null;
    }
}

?>