<?php
namespace Admin\Model;

class Cadcli
{
    public $id_cadcli,$desc_cadcli,$cpf_cadcli,
            $email_cadcli,$telefone_cadcli,$ramal_cadcli,
            $celular_cadcli,$funcao_cadcli,$status_cadcli,
            $cd_caddep,$cd_cadper,$cd_caddir;
    
    public function exchangeArray($data){
    $this->id_cadcli = (isset($data['id_cadcli'])) ? (int)$data['id_cadcli']:null;
    $this->desc_cadcli = (isset($data['desc_cadcli'])) ? trim(strtoupper($data['desc_cadcli'])):null;
    $this->cpf_cadcli = (isset($data['cpf_cadcli'])) ? trim($data['cpf_cadcli']): null;
    $this->telefone_cadcli = (isset($data['telefone_cadcli'])) ? trim($data['telefone_cadcli']):null;
    $this->email_cadcli = (isset($data['email_cadcli'])) ? trim(strtolower($data['email_cadcli'])):null;
    
    $this->ramal_cadcli = (isset($data['ramal_cadcli'])) ? trim($data['ramal_cadcli']):null;
    $this->celular_cadcli = (isset($data['celular_cadcli'])) ? trim($data['celular_cadcli']):null;
    $this->funcao_cadcli = (isset($data['funcao_cadcli'])) ? trim(strtoupper($data['funcao_cadcli'])):null;
    $this->status_cadcli = (isset($data['status_cadcli'])) ? $data['status_cadcli']:null;
    $this->cd_caddep = (isset($data['cd_caddep'])) ? (int)$data['cd_caddep'] : null;
    $this->cd_cadper = (isset($data['cd_cadper'])) ? (int)$data['cd_cadper'] : null;
    $this->senha_cadcli = (isset($data['senha_cadcli'])) ? trim(strtoupper($data['senha_cadcli'])):null;
    $this->cd_caddir = (isset($data['cd_caddir']) && $data['cd_caddir']>0 ) ?  $data['cd_caddir'] : null;
    }
}

?>