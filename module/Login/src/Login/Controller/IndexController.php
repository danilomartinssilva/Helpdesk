<?php
namespace Login\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;


class IndexController extends  AbstractActionController
{
    
    public function indexAction ()
    {
    	$viewModel = new ViewModel();
    	$viewModel->setTerminal(true);
    	return $viewModel;
    }
    public function autenticateAction ()
    {
    	$request = $this->getRequest()->getPost();
    	$email = $request['email_cadcli'];
    	$senha = $request['senha_cadcli'];
    	$acesso = $request['acesso'];
    	// $response = $this->getResponse();
    	$dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
    	$authAdaptor = new AuthAdapter($dbAdapter);
    	$authAdaptor->setTableName("cadcli")
    	->setIdentityColumn("email_cadcli")
    	->setCredentialColumn("senha_cadcli");
    	/*$authAdaptor->getDbSelect()->where(array(
    			'cd_cadper' => 3
    	));*/
    	$authAdaptor->setIdentity($email);
    	$authAdaptor->setCredential($senha);
    	$auth = new AuthenticationService();
    	if($acesso==3){
    	$auth->setStorage(new Session('user'));
    	}
    	if($acesso==2){
    		$auth->setStorage(new Session('tecnico'));
    	}
    	if($acesso==1){
    		$auth->setStorage(new Session('admin'));
    	}
    	
    	$result = $auth->authenticate($authAdaptor);
    	if ($result->isValid()) {
    		$storage = $auth->getStorage();
    		$storage->write($authAdaptor->getResultRowObject(array(    		    
    				"desc_cadcli",
    				"email_cadcli",
    				"id_cadcli",
    		        "cd_cadper"
    		)));
    		
    		if(($acesso==1 || $acesso==2 || $acesso==3) && $storage->read()->cd_cadper==1){
    			
    		    $dados['success'] = true;
    		    $dados['message'] = utf8_encode("PASSOU");
    		    
    		}
    		else if(($acesso==2 || $acesso==3) && $storage->read()->cd_cadper==2){
    		    $dados['success'] = true;
    		    $dados['message'] = utf8_encode("PASSOU");
    		    
    		}
    		else if($acesso==3 && $storage->read()->cd_cadper==3){    			
    		    
    		    $dados['success'] = true;
    		    $dados['message'] = utf8_encode("PASSOU");
    		}
    		else{
    		    $dados['success'] = false;
    		    $dados['message'] = utf8_encode("Você pode não ter acesso permitido para este módulo.");
    		    
    		}   	
    		
    		
    	} else {
    		$dados['success'] = false;
    		$dados['message'] = utf8_encode("Login e/ou senha podem ser inválidos");
    	}
    	return $this->response->setContent(json_encode($dados));
    }
    public function testeAction(){
    	return $this->getResponse()->setContent("MEU TESTE");
        
    }
    
    
}

?>