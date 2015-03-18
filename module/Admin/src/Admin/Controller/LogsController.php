<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class LogsController extends AbstractActionController
{
    protected $cadlogTable;
    public function getCadlogTable(){
    	if(!$this->cadlogTable){
    		$sm = $this->serviceLocator->get('Admin\Model\CadlogTable');
    		$this->cadlogTable = $sm;
    	}
    	return $this->cadlogTable;
        
    }
    
    public function listAction(){
    	

        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));        if ($auth->hasIdentity()) {        
        
        	$request = $this->getRequest()->getPost();
        	$data = json_decode($request->data, true);
        	$filter = json_decode($request->filter, true);
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
        
        	$total = $this->getCadlogTable()
        	->fetchAll($where)
        	->count();
        	$consulta = $this->getCadlogTable()
        	->fetchAll($where,$start,$limit)
        	->getDataSource();
        	$retorno = array();
        	$i = 0;
        	foreach ($consulta as $valor) {
        	$retorno['data'][$i]['id_cadlog'] = $valor['id_cadlog'];
        	$retorno['data'][$i]['usuario'] = $valor['usuario'];
        	$retorno['data'][$i]['target'] = $valor['target'];
        	$retorno['data'][$i]['email'] = $valor['email'];
        	$retorno['data'][$i]['action'] = $valor['action'];
        	$retorno['data'][$i]['date'] = $valor['date'];
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
    
    
    
}

?>
