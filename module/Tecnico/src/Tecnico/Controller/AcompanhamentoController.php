<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadaco;
use Admin\Model\Cadsol;
use Zend\Db\ResultSet\ResultSet;

class AcompanhamentoController extends AbstractActionController
{

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $cadaco = new Cadaco();
            $cadaco->exchangeArray($data);
            $insert = $this->getServiceLocator()
                ->get('Admin\Model\CadacoTable')
                ->saveAcompanhamento($cadaco);
            if ($insert > 0) {
                $cadsol = new Cadsol();
                $cadsol->id_cadsol = $data['cd_cadsol'];
                $cadsol->data_cadsol = $data['atualizacao_cadaco'];
                $cadsol->cd_cadsta = $data['cd_cadsta'];
                $smUpdateStatusCadsol = $this->getServiceLocator()
                    ->get('Admin\Model\CadsolTable')
                    ->updateStatusSolicitacao($data['cd_cadsta'], $data['cd_cadsol']);
                $retorno['success'] = true;
                $retorno['message'] = utf8_encode("Acompanhamento adicionado com sucesso");
                /**
                 * Teste Log
                 */
                
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'tecnico', 'insert', 'acompanhamento');
                /*
                 * Final Log
                */
                $this->enviarEmailUsuario($cadsol->id_cadsol);
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("A operação não foi realizada");
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toUrl('logintecnico');
        }
    }

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            $request = $this->getRequest()->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $filter = json_decode(stripcslashes($request->filter), true);
            if (isset($filter[0]['property']) && isset($filter[0]['value'])) {
                $field = $filter[0]['property'];
                $value = $filter[0]['value'];
                $where = "{$field}={$value}";
            } else {
                $where = null;
            }
            
            $limit = (int) $request['limit'];
            $start = (int) $request['start'];
            // print_r($request['limit']);
            
            $total = $this->getServiceLocator()->get('Admin\Model\CadacoTable')
                ->fetchAll($where)
                ->count();
            $consulta = $this->getServiceLocator()->get('Admin\Model\CadacoTable')
                ->fetchAll($where)
                ->getDataSource();
            $retorno = array();
            $i = 0;
            foreach ($consulta as $valor) {
                $retorno['data'][$i]['id_cadaco'] = $valor['id_cadaco'];
                $retorno['data'][$i]['desc_cadaco'] = $valor['desc_cadaco'];
                $retorno['data'][$i]['desc_cadaco'] = $valor['desc_cadaco'];
                $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                $retorno['data'][$i]['cd_cadsol'] = $valor['cd_cadsol'];
                $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                $retorno['data'][$i]['status']['id_cadsta'] = $valor['id_cadsta'];
                $retorno['data'][$i]['status']['desc_cadsta'] = $valor['desc_cadsta'];
                $retorno['data'][$i]['atualizacao_cadaco'] = $valor['atualizacao_cadaco'];
                $retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
                $retorno['data'][$i]['atendentes']['descricao_atendente'] = $valor['descricao_atendente'];
                $retorno['data'][$i]['atendentes']['id_atendente'] = $valor['id_atendente'];
                $retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
                $retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                $retorno['data'][$i]['perfils']['desc_cadper'] = $valor['desc_cadper'];
                $retorno['data'][$i]['perfils']['id_cadper'] = $valor['id_cadper'];
                $i ++;
            }
            $retorno['success'] = true;
            $retorno['total'] = $total;
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toUrl('login');
        }
    }
    
    public function enviarEmailUsuario ($codigoSolicitacao)
    {
    	// OBTER CÓDIGO CLIENTE
    	$whereSolicitacao[] = "viewsolicitacoes.id_cadsol = {$codigoSolicitacao}";
    	$solicitacao = $this->getServiceLocator()
    	->get('Admin\Model\CadsolTable')
    	->fetchAll($whereSolicitacao);
    	$rows = new ResultSet();
    	$codigoCliente = "";
    	$destinatario = "";
    	foreach ($rows->initialize($solicitacao)->toArray() as $valor) {
    		$codigoCliente = $valor['cd_cadcli'];
    		$nomeCliente = utf8_decode($valor['desc_cadcli']);
    		$statusSolicitacao = utf8_decode($valor['desc_cadsta']);
    		$dataAtualizacao = $valor['data_cadsol'];
    		$atendente =utf8_decode($valor['atendente']);
    		$textoSolicitacao = utf8_decode($valor['desc_cadsol']);
    		$emailCliente = $valor['email_cadcli'];
    
    	}
    	$destinatario[0]['email'] =$emailCliente;
    	$destinatario[0]['nomeDestinatario']= $nomeCliente;
    	//FINAL OBTER CÓDIGO CLIENTE
    	//TEXTO EMAIL
    	//TEXTO DE SOLICITACAO
    	$html = "<strong>Acompanhamento de solicitação: {$codigoSolicitacao}</strong><br></br> Segue abaixo informações do processo de sua solicitação: <br></br>";
    
    	$html.="Código da solicitacão: {$codigoSolicitacao} <br></br>";
    	$html.="Solicitante: {$nomeCliente} <br></br>";
    	$html.="Solicitação: {$textoSolicitacao} <br></br>";
    	$html.="Atendente: {$atendente} <br></br>";
    	$html.="Status: {$statusSolicitacao}<br></br>";
    	$html.="Data de atualizacão: {$dataAtualizacao}<br></br>";
    	$html.="Para mais detalhes da solicitação. Acesse o módulo técnico do sistema: <a href=\"http://64.50.182.163/~hepshego/user/index/login\">Módulo Usuário</a>";
    
          $enviarEmail = $this->EnviarEmail()->Envio($destinatario,"Acompanhamento da solicitação - {$codigoSolicitacao}",$html);
    
              return  $enviarEmail;
    
    
    }
    
}

?>