<?php
namespace Admin\Model;

class Cadperfil
{
    public $id_cadper,$desc_cadper;
    
    public function exchangeArray($dados){
    	$this->id_cadper = (isset($dados['id_cadper'])) ? $dados['id_cadper'] : null;
    	$this->desc_cadper = (isset($dados['desc_cadper'])) ? $dados['desc_cadper'] : null;
    }
    
    
}

?>