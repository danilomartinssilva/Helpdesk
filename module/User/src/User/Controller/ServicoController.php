<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class ServicoController extends AbstractActionController
{
    protected $cadserTable;
    public function listAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('user'));
    	if($auth->hasIdentity()){
    	    $consulta = $this->getCadserTable()->fetchAll()->getDataSource();
    	    $retorno  = array();
    	    $i=0;
    	    foreach($consulta as $valor){	       
	        $retorno['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
	        $retorno['data'][$i]['id_cadser'] = $valor['id_cadser'];
	        $retorno['data'][$i]['obs_cadser'] = $valor['obs_cadser'];
	        $retorno['data'][$i]['cd_cadpri'] = $valor['cd_cadpri'];
	        $retorno['data'][$i]['parent_cadser'] = $valor['parent_cadser'];
	        $retorno['data'][$i]['categorias']['id'] = $valor['id'];
	        $retorno['data'][$i]['categorias']['descricao'] = $valor['descricao'];
	        $i++;
    	    } 
    	    $retorno['success'] = true;
    	    return $this->getResponse()->setContent(json_encode($retorno));   
    	}
    	else{
    	$auth->clearIdentity();
    	$this->redirect()->toRoute('userlogin');	
    	}
    	
    	return $this->getResponse();
    } 
    public function getCadserTable(){
    	if(!$this->cadserTable){
    		$sm = $this->getServiceLocator()->get('Admin\Model\CadserTable');
    		$this->cadserTable = $sm;
    	}
    	return $this->cadserTable;
    }
}

?>