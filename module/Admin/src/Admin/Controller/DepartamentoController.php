<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Model\Caddep;
use Zend\Validator\Db\RecordExists;
use Zend\Validator\Db\NoRecordExists;
use Zend\Filter\StringToUpper;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Controller\Plugin\GerarLog;
// use Admin;
class DepartamentoController extends AbstractActionController
{

    protected $caddepTable;

    public function getCaddepTable ()
    {
        if (! $this->caddepTable) {
            $sm = $this->getServiceLocator();
            $this->caddepTable = $sm->get('Admin\Model\CaddepTable');
        }
        return $this->caddepTable;
    }

    public function listAction ()
    {
        $request = $this->request->getPost();
        $consulta = $this->getCaddepTable()
            ->fetchAll(null, $request['start'], $request['limit'])
            ->getDataSource();
        $dados = array();
        $dados['success'] = true;
        $dados['total'] = (int) $this->getCaddepTable()->count();
        $i = 0;
        foreach ($consulta as $valor) {
            $dados['data'][$i]['id_caddep'] = $valor['id_caddep'];
            $dados['data'][$i]['desc_caddep'] = ($valor['desc_caddep']);
            $dados['data'][$i]['parent_caddep'] = $valor['parent_caddep'];
            $dados['data'][$i]['responsavel_caddep'] = ($valor['responsavel_caddep']);
            $dados['data'][$i]['telefone_caddep'] = $valor['telefone_caddep'];
            $dados['data'][$i]['status_caddep'] = $valor['status_caddep'];
            $dados['data'][$i]['responsaveis']['descricao'] = ($valor['descricao_responsavel']);
            $dados['data'][$i]['responsaveis']['id'] = ($valor['id_responsavel']);
            $i ++;
        }
        
        echo json_encode($dados);
        $response = $this->getResponse();
        return $response;
        // Final do código
    }

    public function indexAction ()
    {
        $this->redirect()->toRoute('departamentoListar');
    }

    public function deleteAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            // Inicio do código
            $data = $this->request->getPost();
            $dados = json_decode(stripslashes($data->data), true);
            $response = $this->getResponse();
            $id = (int) $dados['id_caddep'];
            // $retorno = array();
            if ($this->getCaddepTable()->deleteDepartamento($id) == 1) {
                $retorno['success'] = true;
                $retorno['message'] = utf8_encode("Excluído com sucesso");
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                    ->get('Zend\Db\Adapter\Adapter'), 'admin', 'delete', 'departamento');
                /*
                 * Final Log
                 */
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Não foi possível excluir este registro. \nExistem vínculos relacionados a esta tabela.");
            }
            echo (json_encode($retorno));
            
            return $response;
            // Final do código
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode(stripslashes($request->data), true);
            
            $caddep = new Caddep();
            $caddep->exchangeArray($data);
            $insert = $this->getCaddepTable()->saveDepartamento($caddep);
            if ($insert > 0) {
                $retorno['success'] = true;
                $i = 0;
                $consulta = $this->getCaddepTable()
                    ->fetchAll("caddep.id_caddep={$insert}")
                    ->getDataSource();
                foreach ($consulta as $valor) {
                    $retorno['data'][$i]['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['desc_caddep'] = ($valor['desc_caddep']);
                    $retorno['data'][$i]['parent_caddep'] = $valor['parent_caddep'];
                    $retorno['data'][$i]['responsavel_caddep'] = ($valor['responsavel_caddep']);
                    $retorno['data'][$i]['telefone_caddep'] = $valor['telefone_caddep'];
                    $retorno['data'][$i]['status_caddep'] = $valor['status_caddep'];
                    $retorno['data'][$i]['responsaveis']['descricao'] = ($valor['descricao_responsavel']);
                    $retorno['data'][$i]['responsaveis']['id'] = ($valor['id_responsavel']);
                    $i ++;
                }
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                    ->get('Zend\Db\Adapter\Adapter'), 'admin', 'insert', 'departamento');
                /*
                 * Final Log
                 */
            } else {
                $retorno['success'] = false;
            }
            echo json_encode($retorno);
            return $this->getResponse();
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function updateAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $caddep = new Caddep();
            $caddep->exchangeArray($data);
            $update = $this->getCaddepTable()->updateDepartamento($caddep);
            if (is_array($update)) {
                $retorno['success'] = true;
                $retorno['data'] = $update;
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                    ->get('Zend\Db\Adapter\Adapter'), 'admin', 'update', 'departamento');
            } else {
                $retorno['success'] = false;
            }
            echo json_encode($retorno);
            return $this->response;
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
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
            $pluginValidacaoRemota = $this->RemoteValidate()->validar($this->getCaddepTable(), 'caddep', $field, $id, $value, $this->getServiceLocator()
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
     
    
    
    
}

?>
