<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadsol;
use Admin\Model\Cadaco;
use Zend\Db\ResultSet\ResultSet;
class SolicitacaoController extends AbstractActionController
{
    protected $cadsolTable;
     
    
    public function getCadsolTable(){
        
    	if(!$this->cadsolTable){
    		$sm = $this->getServiceLocator()->get('Admin\Model\CadsolTable');
    		$this->cadsolTable = $sm;
    	}
    	return $this->cadsolTable;
    }
   /**
    * Função de listar as solicitações
    * @return \Zend\Stdlib\mixed|\Zend\Stdlib\ResponseInterface
    */ public function listAction(){
        
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('user'));
        if($auth->hasIdentity()){            
         $request = $this->request->getPost();
         $data = json_decode(stripslashes($request->data),true);
                           
         $idUsuario =(int) $auth->getStorage()->read()->id_cadcli;
         $start =(int) $request->start;
         $limit =(int) $request->limit;
         $where=null;   
         if(isset($request->filter)){
          $filter = json_decode(stripslashes($request->filter),true);
          for($i=0;$i<count($filter);$i++){
              $where[] = "viewsolicitacoes.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
          }  
              
         }
         else{
         	  $where = null;
         }
         $where[]=  "viewsolicitacoes.cd_cadcli={$idUsuario}";
         if(isset($request->sort)){
           $sort = json_decode($request->sort,true);  
         	for($i=0;$i<count($filter);$i++){
         	    $order[] = "viewsolicitacoes.{$sort[$i]['property']} {$sort[$i]['direction']} ";	
         	}
         }
         else{
         	    $order = "viewsolicitacoes.id_cadsol DESC";
         }         
         $consulta = $this->getCadsolTable()->fetchAll($where,$start,$limit,$order);
         
         
         $total = $this->getCadsolTable()->fetchAll($where)->count();
         $retorno = array();
         $retorno['total'] = (int) $total;
         $retorno['success'] = true;
         $rows = new ResultSet();
                  
         $i=0;
         foreach($rows->initialize($consulta)->toArray() as $valor){
            $retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
        	$retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
        	$retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
        	$retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
        	$retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
        	$retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
        	$retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];        	        	
        	$retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];     
        	$retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];   	
        	$retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
        	$retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
        	$retorno['data'][$i]['cd_cadsta']=$valor['cd_cadsta'];
        	$retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
        	$retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
         	$i++;
         }	
            return $this->getResponse()->setContent(json_encode($retorno));
        }
        else{
            $auth->clearIdentity();
            $this->redirect()->toRoute('userlogin');
        }
        
        return $this->getResponse();
        
             	
    }
    public function addAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('user'));
    	if($auth->hasIdentity()){
		$request = $this->request->getPost();
		$data = json_decode(stripslashes($request->data),true);
		$cadsol = new Cadsol();
		$cadsol->exchangeArray($data);
        $insert =(int) $this->getCadsolTable()->saveSolicitacao($cadsol);
        $retorno = array();
            if($insert>0){
            	$retorno['success'] = true;
            	$where = array("viewsolicitacoes.id_cadsol = {$insert}");
            	$consulta = $this->getCadsolTable()->fetchAll($where);
            	$sm = $this->getServiceLocator()->get('Admin\Model\CadacoTable');
            	$cadaco = new Cadaco();
            	$cadaco->desc_cadaco = utf8_encode("Solicitacação aberta.");
            	$cadaco->cd_cadsol = $insert;
            	$cadaco->cd_cadsta = $data['cd_cadsta'];
            	$cadaco->atualizacao_cadaco = $data['data_cadsol'];
            	$cadaco->cd_cadcli = $data["cd_cadcli"];
                $atualizarAcompanhamento = $sm->saveAcompanhamento($cadaco);
                //ENVIO DO EMAIL PARA O TECNICO
                $this->enviarEmailTecnico($insert, $cadsol->cd_cadser, $cadsol->cd_cadcli, $cadsol->data_cadsol);
                //FINAL ENVIO DO EMAIL PARA O TECNICO
            	$i=0;
            	$rows = new ResultSet();
            	foreach($rows->initialize($consulta)->toArray() as $valor){
            		$retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
                	$retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
                	$retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
                	$retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
                	$retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
                	$retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                	$retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];        	        	
                	$retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];     
                	$retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];   	
                	$retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                	$retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
                	$retorno['data'][$i]['cd_cadsta']=$valor['cd_cadsta'];
                	$retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
                	$retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
                    $i++;
            	}
            }
            else{
            	$retorno['success'] = false;
            	$retorno['message'] = utf8_encode("Não foi possível cadastrar esta solicitação.");
            }
            return $this->getResponse()->setContent(json_encode($retorno));
    	}
    	else{
    	$auth->clearIdentity();
    	$this->redirect()->toRoute('userlogin');	
    	}
    	
    } 
    
    public function enviarEmailTecnico($codigoSolicitacao,$codigoServico,$codigoCliente,$dateHora){
    	//OBTER DESCRICAO DO SERVICO//
    	$servico = $this->getServiceLocator()->get('Admin\Model\CadserTable')->fetchAll("cadser.id_cadser = {$codigoServico}")->getDataSource();
    	$descricao_servico = "";
    	foreach($servico as $valor){
    		$descricao_servico = utf8_decode($valor['desc_cadser']);
    		$grupo = $valor['cd_caddir'];
    	}
    	//FINAL DESCRICAO DE SERVICO//
    
    	//OBTER INFORMACOES DO USUARIO SOLICITANTE
    	$cliente = $this->getServiceLocator()->get('Admin\Model\CadcliTable')->fetchAll("cadcli.id_cadcli = {$codigoCliente}")->getDataSource();
    	$nome_cliente = "";
    	$departamento_cliente = "";
    	foreach($cliente as $valor){
    		$nome_cliente = $valor['desc_cadcli'];
    		$departamento_cliente = utf8_decode($valor['desc_caddep']);
    	}
    	// FINAL OBTER INFORMACOES DO USUAIRO SOLICITANTE
    
    	//OBTER INFORMACOES ATENDENNTE
    	$atendente = $this->getServiceLocator()->get('Admin\Model\CadcliTable')->fetchAll("cadcli.cd_caddir = {$grupo}")->getDataSource();
    
    	$nome_atendente = "";
    	$email_atendente = "";
    	$i=0;
    	$destinatario="";
    	foreach($atendente as $valor){
    		$destinatario[$i]['email'] = $valor['email_cadcli'];
    		$destinatario[$i]['nomeDestinatario'] = $valor['desc_cadcli'];
    		$i++;
    
    	}
    	//FINAL OBTER INFORMACOES ATENDENTE
    	//TEXTO DE SOLICITACAO
    	$html = "<html><strong>Uma nova solicitação foi aberta</strong><br></br> Segue abaixo informações da solicitação para mais detalhes:<br></br>";
    
    	$html.="Código da solicitacão: {$codigoSolicitacao} <br></br>";
    	$html.="Tipo de servico: {$descricao_servico} <br></br>";
    	$html.="Solicitante: {$nome_cliente} <br></br>";
    	$html.="Departamento: {$departamento_cliente} <br></br>";
    	$html.="Data de abertura: {$dateHora}<br></br>";
    	$html.="Para mais detalhes da solicitação. Acesse o módulo técnico do sistema: <a href=\"http://64.50.182.163/~hepshego/tecnico/login\">Módulo Técnico</a></html>";
    
    	//FINAL DO TEXTO DA SOLICITACAO
    
    	//ENVIO DA SOLICITACAO
    	$enviarEmail = $this->EnviarEmail()->Envio($destinatario,"Abertura de Nova Solicitação - Código {$codigoSolicitacao}",$html);
    
    	return $this->getResponse()->setContent($enviarEmail);
    
    }
    
        
    
}

?>