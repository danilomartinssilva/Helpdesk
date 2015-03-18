<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\Cadbase;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class BasedeconhecimentoController extends AbstractActionController
{

    public function addAction ()
    {}

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
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
            
            $consulta = $this->getServiceLocator()
                ->get('Admin\Model\CadbaseTable')
                ->fetchAll($where, $start, $limit)
                ->getDataSource();
            ;
            $dados = array();
            $retorno['success'] = true;
            $retorno['total'] = (int) $this->getServiceLocator()
                ->get('Admin\Model\CadbaseTable')
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
        } else {
            $auth->clearIdentity();
            return $this->getResponse();
        }
    }
}

?>