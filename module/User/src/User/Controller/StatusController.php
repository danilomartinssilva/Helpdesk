<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class StatusController extends  AbstractActionController
{
    protected $cadstaTable;
    public function listAction(){
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('user'));
        if($auth->hasIdentity()){
        	$consulta = $this->getCadstaTable()->fetchAll()->getDataSource();
        	$retorno = array();
        	$i=0;
        	foreach($consulta as $value):
        	$retorno['data'][$i]['id_cadsta'] = $value['id_cadsta'];
        	$retorno['data'][$i]['desc_cadsta'] = $value['desc_cadsta'];   
        	$i++;     	
        	endforeach;
        	$retorno['success'] = true;        	
        	return $this->getResponse()->setContent(json_encode($retorno));
        }
        else{
        	$auth->clearIdentity();
        	$this->redirect()->toRoute('userlogin');
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