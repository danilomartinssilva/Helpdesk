<?php
namespace Admin\Model;

class Cadsta
{
    protected $id_cadsta,$desc_cadsta;
    public function exchangeArray($data){
    	$this->id_cadsta = (isset($data['id_cadsta'])) ? (int) $data['id_cadsta'] : null;
    	$this->desc_cadsta = (isset($data['desc_cadsta'])) ?  $data['desc_cadsta'] : null;
    	
    }
}

?>