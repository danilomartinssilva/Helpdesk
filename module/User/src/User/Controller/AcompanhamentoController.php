<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadaco;
use Admin\Model\Cadsol;
class AcompanhamentoController extends AbstractActionController
{
    protected $cadacoTable;
    
    public function listAction(){
    	
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('user'));
        if($auth->hasIdentity()){
        	$request = $this->getRequest()->getPost();
        	$data = json_decode(stripslashes($request->data),true);
        	$filter = json_decode(stripslashes($request->filter),true);
        	if(isset($filter[0]['property']) && isset($filter[0]['value'])){
        		$field = $filter[0]['property'];
        		$value = $filter[0]['value'];
        		$where = "{$field}={$value}";
        	}else{
        	$where = null;
        	}
        		
        		
        	$limit =(int) $request['limit'];
        	$start = (int) $request['start'];
        	//print_r($request['limit']);
        	$sm = $this->getServiceLocator()->get('Admin\Model\CadacoTable');
        	$total = $sm->fetchAll($where)->count();        	
        	$consulta =$sm->fetchAll($where)->getDataSource();
        	$retorno = array();
        	$i=0;
        	foreach($consulta as $valor){
        	$retorno['data'][$i]['id_cadaco'] = $valor['id_cadaco'];
        	$retorno['data'][$i]['desc_cadaco'] = $valor['desc_cadaco'];
        	$retorno['data'][$i]['desc_cadaco'] = $valor['desc_cadaco'];
        	$retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
        	$retorno['data'][$i]['cd_cadsol'] = $valor['cd_cadsol'];
    		$retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
    	    $retorno['data'][$i]['status']['id_cadsta'] = $valor['id_cadsta'];
			$retorno['data'][$i]['status']['desc_cadsta'] = $valor['desc_cadsta'];
			$retorno['data'][$i]['atualizacao_cadaco'] = $valor['atualizacao_cadaco'];
			$retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
    		$retorno['data'][$i]['atendentes']['descricao_atendente'] = $valor['descricao_atendente'];
    		$retorno['data'][$i]['atendentes']['id_atendente'] = $valor['id_atendente'];
    		$retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
    		$retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
    		$retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
    		$retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
    		$retorno['data'][$i]['perfils']['desc_cadper'] = $valor['desc_cadper'];
    		$retorno['data'][$i]['perfils']['id_cadper'] = $valor['id_cadper'];
    		$i++;
        	}
        	$retorno['success'] = true;
    	    $retorno['total'] = $total;
            	    return $this->getResponse()->setContent(json_encode($retorno));        
        	}
        	else{
        	$auth->clearIdentity();
        	$this->redirect()->toUrl('userlogin');
        	}
    }
    public function addAction(){
    	$auth = new AuthenticationService();
    	$auth->setStorage(new Session('user'));
    	if($auth->hasIdentity()){
    		$request = $this->getRequest()->getPost();
    		$data = json_decode($request->data,true);
    		$cadaco = new Cadaco();
    		$cadaco->exchangeArray($data);
    		$sm = $this->getServiceLocator()->get('Admin\Model\CadacoTable');
    		$insert = $sm->saveAcompanhamento($cadaco);
    		$retorno = array();
    		if($insert>0){
    			$cadsol = new Cadsol();
    			$cadsol->id_cadsol = $data['cd_cadsol'];
    			$cadsol->cd_cadsta = $data['cd_cadsta'];
    			$smUpdateStatusCadsol = $this->getServiceLocator()->get('Admin\Model\CadsolTable')->updateStatusSolicitacao($data['cd_cadsta'],$data['cd_cadsol']);
    			 
    			$retorno['success'] = true;
    		}
    		else{
    			$retorno['success'] = false;
    		}
    		return $this->getResponse()->setContent(json_encode($retorno));
    	}
    	else{
    		$auth->clearIdentity();
    		$this->redirect()->toRoute('userlogin');
    	}
    
    }
}

?>