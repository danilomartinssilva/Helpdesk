<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class StatusController extends AbstractActionController
{

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            $consulta = $this->getServiceLocator()
                ->get('Admin\Model\CadstaTable')
                ->fetchAll()
                ->getDataSource();
            $i = 0;
            $retorno = array();
            $retorno['success'] = true;
            foreach ($consulta as $valor) {
                $retorno['data'][$i]['id_cadsta'] = $valor['id_cadsta'];
                $retorno['data'][$i]['desc_cadsta'] = $valor['desc_cadsta'];
                $retorno['data'][$i]['id_cadsta'] = $valor['id_cadsta'];
                $i ++;
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('logintecnico');
        }
    }
}

?>