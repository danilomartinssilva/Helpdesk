<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
class PerfilController extends AbstractActionController
{
    protected $cadperfilTable;
    
    public function indexAction(){
    	
        $this->redirect()->toRoute('perfil');
        
    }
    public function listAction(){
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if($auth->hasIdentity()){
        //Inicio do código
        $consulta = ($this->getCadperfilTable()->fetchAll()->getDataSource());
        $dados = array();
        $i=0;
        foreach($consulta as $valor){
        	$dados['data'][$i]['id_cadper'] = $valor['id_cadper'];
        	$dados['data'][$i]['desc_cadper'] = ($valor['desc_cadper']);
        	$i++;
        }    
        $dados['success'] = true;
       echo json_encode($dados);
        return $this->getResponse();
        }
        else{
        	$auth->clearIdentity();
        	$this->redirect()->toRoute('login');
        }
        
    }
    public function getCadperfilTable(){
    	if(!$this->cadperfilTable){
    		$this->cadperfilTable= $this->serviceLocator->get('\Admin\Model\CadperfilTable');
    		
    	}
    	return $this->cadperfilTable;
    }
    
    
    
}

?>