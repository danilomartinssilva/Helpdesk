<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadbase;

class BasedeconhecimentoController extends AbstractActionController
{

    protected $cadbaseTable;

    public function getCadbaseTable ()
    {
        if (! $this->cadbaseTable) {
            $sm = $this->getServiceLocator();
            $this->cadbaseTable = $sm->get('Admin\Model\CadbaseTable');
        }
        return $this->cadbaseTable;
    }

    public function addAction ()
    {
        $request = $this->request->getPost();
        $data = json_decode(stripslashes($request->data), true);
        
        $cadbase = new Cadbase();
        $cadbase->exchangeArray($data);
        $cadbase->atualizacao_cadbase = date('Y-m-d H:i:s');
        $insert = $this->getCadbaseTable()->saveBase($cadbase);
        if ($insert > 0) {
            $retorno['success'] = true;
            $i = 0;
            $consulta = $this->getCadbaseTable()
                ->fetchAll("cadbase.id_cadbase={$insert}")
                ->getDataSource();
            foreach ($consulta as $valor) {
                $retorno['data'][$i]['id_cadbase'] = $valor['id_cadbase'];
                $retorno['data'][$i]['titulo_cadbase'] = ($valor['titulo_cadbase']);
                $retorno['data'][$i]['texto_cadbase'] = $valor['texto_cadbase'];
                $retorno['data'][$i]['atualizacao_cadbase'] = $valor['atualizacao_cadbase'];
                $retorno['data'][$i]['autor_cadbase'] = $valor['autor_cadbase'];
                $i ++;
            }
            /**
             * Teste Log
             */
            $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
            		->get('Zend\Db\Adapter\Adapter'), 'admin', 'insert', 'base de conhecimento');
            /*
             * Final Log
            */
        } else {
            $retorno['success'] = false;
        }
        echo json_encode($retorno);
        return $this->getResponse();
    }

    public function listAction ()
    {
        $request = $this->request->getPost();
        $filter = json_decode(stripslashes($request->filter), true);
        if (isset($filter[0]['property']) && isset($filter[0]['value'])) {
            $field = $filter[0]['property'];
            $value = $filter[0]['value'];
            $where = "{$field}={$value}";
        } else {
            $where = null;
        }
        
        $limit = (isset($request['limit'])) ? (int) $request['limit'] : null;
        $start = (isset($request['start'])) ? (int) $request['start'] : null;
        
        $consulta = $this->getCadbaseTable()
            ->fetchAll($where, $start, $limit)
            ->getDataSource();
        $dados = array();
        $retorno['success'] = true;
        $retorno['total'] = (int) $this->getCadbaseTable()
            ->fetchAll()
            ->count();
        $i = 0;
        
        foreach ($consulta as $valor) {
            // print_r($valor);
            $retorno['data'][$i]['id_cadbase'] = $valor['id_cadbase'];
            $retorno['data'][$i]['titulo_cadbase'] = ($valor['titulo_cadbase']);
            $retorno['data'][$i]['texto_cadbase'] = $valor['texto_cadbase'];
            $retorno['data'][$i]['atualizacao_cadbase'] = $valor['atualizacao_cadbase'];
            $retorno['data'][$i]['autor_cadbase'] = $valor['autor_cadbase'];
            $i ++;
        }
        echo json_encode($retorno);
        $response = $this->getResponse();
        return $response;
        // Final do código
    }

    public function deleteAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()){
        $request = $this->getRequest()->getPost();
        $data = json_decode(stripslashes($request->data),true);
        $idBase = $data['id_cadbase'];
        $delete = $this->getCadbaseTable()->deleteBase($idBase);
        //print_r($delete);
        //print_r($delete);
        if($delete==0){
            $retorno['success'] = false;
            $retorno['message'] = utf8_encode("Não foi possível excluir o artigo neste momento. Tente novamente!");
            /**
             * Teste Log
             */
            $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
            		->get('Zend\Db\Adapter\Adapter'), 'admin', 'delete', 'base de conhecimento');
            /*
             * Final Log
            */
        }  
        else{
        	
            $retorno['success'] = true;
            $retorno['message'] = utf8_encode("Artigo excluído com sucesso.");
            
        	
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