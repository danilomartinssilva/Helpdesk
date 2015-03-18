<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class IndexController extends AbstractActionController
{

    public function indexAction ()
    {
            $auth = new AuthenticationService();
            $auth->setStorage(new Session('tecnico'));
            if($auth->hasIdentity()){
                $viewModel = new ViewModel();
                $viewModel->setTerminal(true);
                return $viewModel;
            } 
            else{
            	$auth->clearIdentity();
            	$this->redirect()->toRoute('logintecnico');
            }
        	
        
    }

    public function loginAction ()
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
        //$response = $this->getResponse();
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $authAdaptor = new AuthAdapter($dbAdapter);
        $authAdaptor->setTableName("cadcli")->setIdentityColumn("email_cadcli")->setCredentialColumn("senha_cadcli");
        $authAdaptor->setIdentity($email);
        $authAdaptor->getDbSelect()->where(array('cadcli.cd_cadper'=>2));
        $authAdaptor->setCredential($senha);
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        $result = $auth->authenticate($authAdaptor);
        if($result->isValid()){
        	$storage =$auth->getStorage();
        	$storage->write($authAdaptor->getResultRowObject(array(
        			"desc_cadcli",
        			"email_cadcli",
        			"id_cadcli",
        	        "cd_caddir"
        	)));
        	$dados['success'] = true;
        	$dados['message'] = "PASSOU";
        
        }
        else{
        	$dados['success'] = false;
        	$dados['message'] = utf8_encode("Senha e/ou Email não existem.");
        }
        return $this->response->setContent(json_encode($dados));
    }

    public function logoutAction ()
    {
       $response = $this->getResponse();
    	$auth = new AuthenticationService();
    	if($auth->setStorage(new Session('tecnico'))){
    		$auth->clearIdentity();
    		$dados['success']=true;
    		echo json_encode($dados); 
    	}
    	return $response;
    }

    public function headerAction (){  
        $auth = new AuthenticationService();
   	    $auth->setStorage(new Session('tecnico'));
   	    if($auth->hasIdentity()){
   	        $url =__DIR__;
   	        $endereco = "";
   	       if(substr_count($url,"HelpDesk")>0){
   	       	$endereco = "/helpdesk/public/";
   	           
   	       } 
   	       else{
   	       	$endereco = "/~hepshego/";
   	       }
   	        
   	        $storage = $auth->getStorage();
   	        $nomeUsuario = $storage->read()->desc_cadcli;
   	        $idUsuario = $storage->read()->id_cadcli;
   	        $caddir = $storage->read()->cd_caddir;
   	        $url = $endereco;
   	        $dataServer = array('desc_cadcli'=>$nomeUsuario,'id_cadcli'=>$idUsuario,'url'=>$endereco,'cd_caddir'=>$caddir);   	        
   	        echo "window.dataServerUsuario =".json_encode($dataServer);
   	       return $this->getResponse();
   	        
   	    }
   	    else{
   	    	$auth->clearIdentity();
   	    	$this->redirect()->toRoute('tecnicologin');
   	    }   
        
       
    }
    public function menuAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('tecnico'));
    	if($auth->hasIdentity()){
    	    $menu['data'][0]['id'] = utf8_encode('Solicitações');
    	    $menu['data'][0]['iconCls'] = 'icone_chamados';
    	    $menu['data'][0]['leaf'] = true;
    	    $menu['data'][0]['expanded'] = true;
    	    $menu['data'][0]['children']['id'] = "lissol";
    	    $menu['data'][0]['children']['text'] = utf8_encode("Listar Solicitações");
    	    $menu['data'][0]['children']['leaf'] = true;
    	    //Acompanhamento
    	    $menu['data'][1]['id'] = utf8_encode('Acompanhamento');
    	    $menu['data'][1]['iconCls'] = 'icone_lupa';
    	    $menu['data'][1]['leaf'] = true;
    	    $menu['data'][1]['expanded'] = true;
    	    $menu['data'][1]['children']['id'] = "lisaco";
    	    $menu['data'][1]['children']['text'] = "Listar Acompanhamentos";
    	    $menu['data'][1]['children']['leaf'] = true;
    	    
    	    
    	    //Base de conhecimentos
    	    $menu['data'][2]['id'] = utf8_encode('Base de conhecimento');
    	    $menu['data'][2]['iconCls'] = 'icone_lupa';
    	    $menu['data'][2]['leaf'] = true;
    	    $menu['data'][2]['expanded'] = true;
    	    $menu['data'][2]['children']['id'] = "lisbase";
    	    $menu['data'][2]['children']['text'] = "Listar artigos";
    	    $menu['data'][2]['children']['leaf'] = true;
    	    return $this->getResponse()->setContent(json_encode($menu));
    	}
    	else{
    	   $auth->clearIdentity();
    	   return $this->getResponse();
    	}
        
        
    }
}

?>