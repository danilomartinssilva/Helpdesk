<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class StatusController extends AbstractActionController
{
    protected $cadstaTable;
    public function listAction(){
        
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('admin'));
    	if($auth->hasIdentity()){
    	    $request = $this->getRequest()->getPost();
    	    $data = json_decode($request->data,true);
    	    $filter = json_decode($request->filter,true);
    	    if(isset($filter[0]['property']) && isset($filter[0]['value'])){
    	        $property = $filter[0]['property'];
    	        $value = $filter[0]['value'];
    	    	$where = "cadsta.{$property} = {$value}";  	    	
    	    }
    	    else{
    	        
    	    	$where=null;
    	    }
    	    $consulta = $this->getCadstaTable()->fetchAll()->getDataSource();
    	    $total = $this->getCadstaTable()->fetchAll()->count();
    	    $retorno = array();
    	    $i=0;
    	     foreach($consulta as $valor){
    	     	$retorno['data'][$i]['id_cadsta'] = $valor['id_cadsta'];
    	     	$retorno['data'][$i]['desc_cadsta'] = $valor['desc_cadsta'];
    	     	$i++;
    	     }      
    	    return $this->getResponse()->setContent(json_encode($retorno));
    	}else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('login');
    	}
    }
    public function getCadstaTable(){
    	if(!$this->cadstaTable){
    		$sm = $this->getServiceLocator()->get('Admin\Model\CadstaTable');
    		$this->cadstaTable = $sm;
    	}
    	return $this->cadstaTable;
    }
    
}

 
?>