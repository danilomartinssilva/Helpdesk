<?php
namespace Admin\Model;

class Caddep
{
    public $id_caddep;
    public $desc_caddep;
    public $responsavel_caddep;
    public $parent_caddep;
    public $telefone_caddep;
    public $status_caddep;
    
    public function exchangeArray($data)
    {
    	$this->id_caddep = (isset($data['id_caddep'])) ? $data['id_caddep'] : null;    
    	$this->desc_caddep = (isset($data['desc_caddep'])) ? strtoupper($data['desc_caddep']) : null;
    	$this->responsavel_caddep = (isset($data['responsavel_caddep'])) ? strtoupper($data['responsavel_caddep']) : null;
    	$this->parent_caddep = (isset($data['parent_caddep'])) ? $data['parent_caddep'] : null;
    	$this->telefone_caddep = (isset($data['telefone_caddep'])) ? $data['telefone_caddep'] : null;
    	$this->status_caddep = (isset($data['status_caddep'])) ? $data['status_caddep'] : null;
    }
    
}

?>