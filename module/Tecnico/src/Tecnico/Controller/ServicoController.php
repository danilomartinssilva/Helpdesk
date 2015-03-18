<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Controller\Plugin\GerarLog;
class ServicoController extends AbstractActionController
{
    public function listAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('tecnico'));
    	if($auth->hasIdentity()){
    	    
    	$consulta = $this->getServiceLocator()->get('Admin\Model\CadserTable')->fetchAll()->getDataSource();
    	$i=0;
    	$retorno = array();
    	$retorno['success'] = true;
    	foreach($consulta as $valor){
    	    $retorno['data'][$i]['prioridades']['id_cadpri'] = $valor['id_cadpri'];
    	    $retorno['data'][$i]['prioridades']['desc_cadpri']= $valor['desc_cadpri'];
    	    $retorno['data'][$i]['prioridades']['componente_cadpri']= $valor['componente_cadpri'];
    	    $retorno['data'][$i]['prioridades']['tempo_cadpri']= $valor['tempo_cadpri'];
    	    $retorno['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
    	    $retorno['data'][$i]['id_cadser'] = $valor['id_cadser'];
    	    $retorno['data'][$i]['obs_cadser'] = $valor['obs_cadser'];
    	    $retorno['data'][$i]['cd_cadpri'] = $valor['cd_cadpri'];
    	    $retorno['data'][$i]['parent_cadser'] = $valor['parent_cadser'];
    	    $retorno['data'][$i]['categorias']['id'] = $valor['id'];
    	    $retorno['data'][$i]['categorias']['descricao'] = $valor['descricao'];
    	    $i++;
    	    }
    	    
    	    
    	    //$log->log($this->tableGateway->getAdapter(), 'admin','read','direcionamento');
    	    
    		return $this->getResponse()->setContent(json_encode($retorno));    
    	}
    	else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('logintecnico');
    		
    	}
    }
}

?>