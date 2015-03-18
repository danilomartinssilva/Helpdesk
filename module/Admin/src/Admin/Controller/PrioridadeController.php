<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class PrioridadeController extends AbstractActionController
{
    protected $cadpriTable;
    public function getCadpriTable(){
    	if(!$this->cadpriTable){
    		$sm = $this->serviceLocator->get('Admin\Model\CadpriTable');
    		$this->cadpriTable = $sm;
    	}
    	return $this->cadpriTable;
    }
    
    public function indexAction(){
    	
        return $this->getResponse();
        
    }
    public function listAction(){        
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('admin'));
    	if($auth->hasIdentity()){
    		$consulta = $this->getCadpriTable()->fetchAll()->getDataSource();
    		$i=0;
    		$dados = array();
    		foreach($consulta as $valor){
    		    
    		    $dados['data'][$i]['id_cadpri'] = $valor['id_cadpri'];
    		    $dados['data'][$i]['desc_cadpri'] = $valor['desc_cadpri'];
    		    $dados['data'][$i]['componente_cadpri'] = $valor['componente_cadpri'];
    		    $dados['data'][$i]['tempo_cadpri'] = $valor['tempo_cadpri'];
    		    $i++;
    		}
    	$dados['success'] = true;
    	$dados['total'] = $this->cadpriTable->count();	
    	  return $this->getResponse()->setContent(json_encode($dados));
    	}else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('login');
    	}
        
        
    }
}


