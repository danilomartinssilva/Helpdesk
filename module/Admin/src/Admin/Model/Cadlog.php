<?php
namespace Admin\Model;

class Cadlog
{
    public $id_cadlog,$sql_log,$user_log,$data_log,$email,$target;
    public function exchangeArray($data){
    	$this->id_cadlog = (isset($data['id_cadlog'])) ? $data['id_cadlog'] : null;
    	$this->sql_log = (isset($data['usuario'])) ? $data['usuario'] : null;
    	$this->user_log = (isset($data['action'])) ? $data['action'] : null;
    	$this->data_log = (isset($data['date'])) ? $data['date'] : null;
    	$this->email = (isset($data['email'])) ? $data['email'] : null;
    	$this->target = (isset($data['target'])) ? $data['target']:null;
         
    }
    
}

?>
