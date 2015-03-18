<?php
namespace Admin\Model;

class Cadbase
{
    
    
    public $id_cabase,$titulo_cadbase,$texto_cadbase,$atualizacao_cadbase,$autor_cadbase;
    
    public function exchangeArray($data){
    	
        $this->id_cabase =(isset($data['id_cabase'])) ? $data['id_cadbase'] : null;
        $this->titulo_cadbase = (isset($data['titulo_cadbase'])) ? $data['titulo_cadbase'] : null;
        $this->autor_cadbase = (isset($data['autor_cadbase'])) ? $data['autor_cadbase']:null;
        $this->atualizacao_cadbase = (isset($data['atualizacao_cadbase'])) ? $data['atualizacao_cadbase']:null;
        $this->texto_cadbase = (isset($data['texto_cadbase'])) ? $data['texto_cadbase'] : null;
        
        
        
    }
}

?>