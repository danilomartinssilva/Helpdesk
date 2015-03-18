<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;

class ClienteController extends AbstractActionController
{

    public function listAction ()
    {
        
        // public function validar($serviceLocator,$tableName,$field,$id=null,$valor){
        // print_r($this->RemoteValidate()->validar($this->getCadcliTable(),'cadcli','cpf_cadcli',null,'03531157116',$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')));
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            
            // INICIO DO CÓDIGO
            $dados = array();
            $request = $this->request->getPost();
            if ($request['limit'] > 0) {
                $limit = $request['limit'];
            } else {
                $limit = 25;
            }
            if ($request['start'] > 0) {
                $start = $request['start'];
            } else {
                $start = null;
            }
            
            $where = null;
            if (isset($request->filter)) {
                $filter = json_decode($request->filter, true);
                if(isset($filter[0]['operator'])){
                    for ($i = 0; $i < count($filter); $i ++) {
                        $where[] = "cadcli.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
                    }
                }
            } else {
                $where = null;
            }
            $consulta = $this->getServiceLocator()
                ->get('Admin\Model\CadcliTable')
                ->fetchAll($where, $start, $limit)
                ->getDataSource();
            $total = (int) $this->getServiceLocator()
                ->get('Admin\Model\CadcliTable')
                ->fetchAll($where)
                ->count();
            $dados['total'] = $total;
            $i = 0;
            foreach ($consulta as $valor) {
                $dados['data'][$i]['id_cadcli'] = $valor['id_cadcli'];
                $dados['data'][$i]['desc_cadcli'] = $valor['desc_cadcli'];
                $dados['data'][$i]['cpf_cadcli'] = $valor['cpf_cadcli'];
                $dados['data'][$i]['email_cadcli'] = $valor['email_cadcli'];
                $dados['data'][$i]['telefone_cadcli'] = $valor['telefone_cadcli'];
                $dados['data'][$i]['ramal_cadcli'] = $valor['ramal_cadcli'];
                $dados['data'][$i]['celular_cadcli'] = $valor['celular_cadcli'];
                $dados['data'][$i]['funcao_cadcli'] = $valor['funcao_cadcli'];
                $dados['data'][$i]['status_cadcli'] = $valor['status_cadcli'];
                $dados['data'][$i]['cd_caddep'] = $valor['cd_caddep'];
                $dados['data'][$i]['cd_cadper'] = $valor['cd_cadper'];
                $dados['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                $dados['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                $dados['data'][$i]['perfils']['desc_cadper'] = $valor['desc_cadper'];
                $dados['data'][$i]['perfils']['id_cadper'] = $valor['id_cadper'];
                $dados['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                $i ++;
            }
            echo json_encode($dados);
            return $this->getResponse();
            // final do codigo
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('logintecnico');
        }
    }
}

?>