<?php
namespace Admin\Model;


class Cadsol
{
    public $id_cadsol,$desc_cadsol,$cd_cadcli,$cd_cadser,$data_cadsol,$cd_cadsta;
    public function exchangeArray($data){
         $this->id_cadsol = (isset($data['id_cadsol'])) ? (int) $data['id_cadsol'] : null;
         $this->desc_cadsol = (isset($data['desc_cadsol'])) ?  $data['desc_cadsol'] : null;
         $this->cd_cadcli = (isset($data['cd_cadcli'])) ? (int) $data['cd_cadcli'] : null;
         $this->cd_cadser = (isset($data['cd_cadser'])) ? (int) $data['cd_cadser'] : null;
         $this->data_cadsol = (isset($data['data_cadsol'])) ?  $data['data_cadsol'] : null;
         $this->cd_cadsta = (isset($data['cd_cadsta'])) ?  $data['cd_cadsta'] : null;
         
         
    }   
}

?>