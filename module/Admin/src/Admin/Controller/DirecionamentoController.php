<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Caddir;
class DirecionamentoController extends AbstractActionController
{
    protected $caddirTable;
    public function getCaddirTable(){
    	if(!$this->caddirTable){
            $sm = $this->getServiceLocator()->get('\Admin\Model\CaddirTable');
            $this->caddirTable = $sm;    	    	    
    	}
    	return $this->caddirTable;
    }
    public function listAction(){
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if($auth->hasIdentity()){
        	$request = $this->getRequest()->getPost();
        	//$limit = (int) $request['limit'];
        	//$start = (int) $request['start'];
        	
        	$consulta = $this->getCaddirTable()->fetchAll()->getDataSource();
        	$retorno  = array();
        	$retorno['total'] = $this->getCaddirTable()->fetchAll()->count();
        	if($retorno['total']>0){
        	    $i=0;
        	    foreach($consulta as $valor){
        	    	$retorno['data'][$i]['id_caddir'] = $valor['id_caddir'];
        	    	$retorno['data'][$i]['descricao_caddir'] = $valor['descricao_caddir'];
        	       	$i++;
        	    }
        	    $retorno['success'] = true;
        	}
        	else{
        	    $retorno['success'] = true;	
        	}
        	return $this->getResponse()->setContent(json_encode($retorno));
        	
        }
        else{
        	$auth->clearIdentity();
        	$this->redirect()->toRoute('login');
        }
    }
    public function addAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('admin'));
    	if($auth->hasIdentity()){
    	    $request = $this->request->getPost();
    	    $data = json_decode(stripslashes($request->data),true);
    	    $caddir = new Caddir();
    	    $caddir->exchangeArray($data);
    	    $insert = $this->getCaddirTable()->saveDirecionamento($caddir);
    	    $retorno = array();
    	    if($insert>0){
    	    	$retorno['success'] = true;
    	    	$where = array("caddir.id_caddir = {$insert}");
    	    	$consulta = $this->getCaddirTable()->fetchAll($where)->getDataSource();
    	    	$i=0;
    	    	foreach($consulta as $valor){
    	    		$retorno['data'][$i]['id_caddir'] = $valor['id_caddir'];
    	    		$retorno['data'][$i]['descricao_caddir'] = $valor['descricao_caddir'];
    	    		$i++;
    	    	}
    	    	/**
    	    	 * Teste Log
    	    	 */
    	    	$gerarLog = $this->GerarLog()->log($this->getServiceLocator()
    	    			->get('Zend\Db\Adapter\Adapter'), 'admin', 'insert', 'direcionamento');
    	    	/*
    	    	 * Final Log
    	    	*/
    	    }    
    	    else{
    	    	$retorno['success'] = false; 
    	    }	
    	    return $this->getResponse()->setContent(json_encode($retorno));	
    	}
    	else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('admin');
    		
    	}
        
    }
    public function validateremoteAction ()
    {
        $auth = new AuthenticationService();
    	$auth->setStorage(new Session('admin'));
    	if ($auth->hasIdentity()) {
    		$request = $this->request->getPost();
    		$field = trim($request['field']);
    		$value = trim($request['value']);
    		$id = (isset($request['idcampo'])) ? (int) $request['idcampo'] : null;
    		// public function validar($serviceLocator,$tableName,$field,$id=null,$value,$adapter){
    		$pluginValidacaoRemota = $this->RemoteValidate()->validar($this->getCaddirTable(), 'caddir', $field, $id, $value, $this->getServiceLocator()
    				->get('Zend\Db\Adapter\Adapter'));
    		//print_r($pluginValidacaoRemota);
    		//  return $this->getResponse()->setContent(json_encode($this->validacaoRemota($request['field'],$request['value'],$request['id'])));
    		return $this->getResponse()->setContent(json_encode($pluginValidacaoRemota));
    	}
    
    	else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('admin');
    	}
    
    }
    
    public function deleteAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('admin'));
    	if($auth->hasIdentity()){
    		$request = $this->getRequest()->getPost();
    		$data = json_decode(stripslashes($request->data),true);
    		$idDirecionamento = $data['id_caddir'];
    		$delete = $this->getCaddirTable()->deleteDirecionamento($idDirecionamento);
    		//print_r($delete);
    		
    		if($delete==0){
    		$retorno['success'] = false;
    		$retorno['message'] = utf8_encode("Existem vínculos de usuários e serviços relacionado à este grupo.");
    		/**
    		 * Teste Log
    		 */
    		$gerarLog = $this->GerarLog()->log($this->getServiceLocator()
    				->get('Zend\Db\Adapter\Adapter'), 'admin', 'delete', 'direcionamento');
    		/*
    		 * Final Log
    		*/
    	    }
    		else{
		    $retorno['success'] = true;
		    $retorno['message'] = utf8_encode("Grupo de direcionamento excluído com sucesso.");
		    
    		}
    	    return $this->getResponse()->setContent(json_encode($retorno));
    	}
    	else{
         $auth->clearIdentity();
         return false;
    	}
    }
    
    
}

?>