<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\Cadcli;

class ClienteController extends AbstractActionController
{

    public function addAction ()
    {
        
        // Inicio do código
        $request = $this->request->getPost();
        $data = json_decode(stripslashes($request->data), true);
        
        $cadcli = new Cadcli();
        $cadcli->exchangeArray($data);
        $insert = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->saveCliente($cadcli);
        // print_r($insert);
        if ($insert > 0) {
            $retorno['success'] = true;
            $retorno['message'] = utf8_encode("Cadastro realizado com sucesso!");
            
        } else {
            $retorno['success'] = false;
            $retorno['message'] = utf8_encode("O cadastro não pode ser realizado tente novamente!");
        }
        $this->envioEmailNovoCadastroToAdministrador($insert);
       
        return $this->getResponse()->setContent(json_encode($retorno));
        
        // Final do código
    }

    public function envioEmailNovoCadastroToAdministrador ($codigoCliente)
    {
        // OBTER INFORMACOES DO USUARIO SOLICITANTE
        $cliente = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->fetchAll("cadcli.id_cadcli = {$codigoCliente}")
            ->getDataSource();
        $nome_cliente = "";
        
        foreach ($cliente as $valor) {
            $id_cliente = $valor['id_cadcli'];
            $nome_cliente = $valor['desc_cadcli'];
            $email_cliente = $valor['email_cadcli'];
            $codigoDepartamento = $valor['cd_caddep'];
        }
        // FINAL OBTER INFORMACOES DO USUAIRO SOLICITANTE
        
        // OBTER INFORMACOES DEPARTAMENTO
        $departamento = $this->getServiceLocator()
            ->get('Admin\Model\CaddepTable')
            ->fetchAll("caddep.id_caddep = {$codigoDepartamento}")
            ->getDataSource();
        foreach ($departamento as $valor) {
            $nome_departamento = $valor['desc_caddep'];
        }
        
        // FINAL OBTER INFORMACOES DEPARTAMENTO
        
        // OBTER INFORMACOES ATENDENTE
        
        $atendente = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->fetchAll("cadcli.cd_cadper = 1")
            ->getDataSource();
        $j = 0;
        foreach ($atendente as $valor) {
            $destinatario[$j]['nomeDestinatario'] = $valor['desc_cadcli'];
            $destinatario[$j]['email'] = $valor['email_cadcli'];
            $j ++;
        }
        
        // FINAL OBTER INFORMACOES ATENDENTE
        
        // TEXTO DE SOLICITACAO
        $html = "<html><strong>Um nova solicitação de acesso foi realizada</strong><br></br> Segue abaixo informações para ativar o acesso:<br></br>";
        $html .= "Código: {$codigoCliente} <br></br>";
        $html .= "Nome: {$nome_cliente} <br></br>";
        $html .= "Email: {$email_cliente} <br></br>";
        $html .= "Departamento: {$nome_departamento}<br></br>";
        $html .= "Acesse: <a href=\"http://64.50.182.163/~hepshego/admin/index/login\">Módulo Administrador</a></html>";
        
        // FINAL DO TEXTO DA SOLICITACAO
        
        // ENVIO DA SOLICITACAO
        $enviarEmail = $this->EnviarEmail()->Envio($destinatario, "Solicitacao de Acesso ao Módulo Usuário  - Código {$codigoCliente}", $html);
        
        return $enviarEmail;
    
    }
    
}

?>