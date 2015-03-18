<?php
namespace Admin\Model;

class Cadser
{
    public $id_cadser,$desc_cadser,$status_cadser,$obs_cadser,$cd_cadpri,$parent_cadser,$cd_caddir,$tempo_cadser;
    public function exchangeArray($data){
    	$this->id_cadser = (isset($data['id_cadser'])) ? (int) $data['id_cadser'] : null;
    	$this->desc_cadser = (isset($data['desc_cadser'])) ?  $data['desc_cadser']:null;
    	$this->status_cadser = (isset($data['status_cadser'])) ? (int) $data['status_cadser']:null;
    	$this->obs_cadser = (isset($data['obs_cadser'])) ?  $data['obs_cadser']:null;
    	$this->cd_cadpri = (isset($data['cd_cadpri'])) ? (int) $data['cd_cadpri']:null;
    	$this->parent_cadser = (isset($data['parent_cadser'])) ?  $data['parent_cadser']:null;
    	$this->cd_caddir = (isset($data['cd_caddir'])) ? $data['cd_caddir'] : null;
        $this->tempo_cadser = (isset($data['tempo_cadser'])) ? $data['tempo_cadser'] : null;
    }
}

?>
