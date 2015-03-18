<?php
namespace Admin\Model;

class Cadaco
{
    public $id_cadaco,$desc_cadaco,$cd_cadsol,$cd_cadsta,$atualizacao_cadaco,$cd_cadcli;
    public function exchangeArray($data){
    	$this->id_cadaco = (isset($data['id_cadaco'])) ? $data['id_cadaco'] : null;
    	$this->desc_cadaco = (isset($data['desc_cadaco'])) ? $data['desc_cadaco'] : null;
    	$this->cd_cadsol = (isset($data['cd_cadsol'])) ? (int) $data['cd_cadsol'] : null;
    	$this->cd_cadcli = (isset($data['cd_cadcli'])) ?(int) $data['cd_cadcli'] : null; 
    	$this->cd_cadsta = (isset($data['cd_cadsta'])) ? (int) $data['cd_cadsta'] : null;
    	$this->atualizacao_cadaco = (isset($data['atualizacao_cadaco'])) ?  $data['atualizacao_cadaco'] : null;
     	  	
        
    }
    
    
}

?>