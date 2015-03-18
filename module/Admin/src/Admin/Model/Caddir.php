<?php
namespace Admin\Model;

class Caddir
{
    public $id_caddir,$descricao_caddir;
    public function exchangeArray($data){
    	$this->id_caddir = (isset($data['id_caddir'])) ? (int) $data['id_caddir'] : null;
    	$this->desc_caddir = (isset($data['descricao_caddir'])) ?  $data['descricao_caddir'] : null;
    	
        
    }
}

?>