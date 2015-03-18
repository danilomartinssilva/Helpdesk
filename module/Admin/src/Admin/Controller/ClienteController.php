<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Admin\Model\Cadcli;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Authentication\Validator\Authentication;
use Zend\Validator\Db\NoRecordExists;
use Admin\Controller\Plugin\GerarLog;

class ClienteController extends AbstractActionController
{

    protected $cadcliTable;

    public function getCadcliTable ()
    {
        if (! $this->cadcliTable) {
            $sm = $this->serviceLocator->get('Admin\Model\CadcliTable');
            $this->cadcliTable = $sm;
        }
        return $this->cadcliTable;
    }

    public function indexAction ()
    {
        return $this->redirect()->toRoute('cliente');
    }

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            // Inicio do código
            $request = $this->request->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $cadcli = new Cadcli();
            $cadcli->exchangeArray($data);
            $insert = $this->getCadcliTable()->saveCliente($cadcli);
            if ($insert > 0) {
                $retorno['success'] = true;
                $consulta = $this->getCadcliTable()
                    ->fetchAll("cadcli.id_cadcli={$insert}")
                    ->getDataSource();
                $i = 0;
                foreach ($consulta as $valor) {
                    $retorno['data'][$i]['id_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['desc_cadcli'] = $valor['desc_cadcli'];
                    $retorno['data'][$i]['cpf_cadcli'] = $valor['cpf_cadcli'];
                    $retorno['data'][$i]['email_cadcli'] = $valor['email_cadcli'];
                    $retorno['data'][$i]['senha_cadcli'] = $valor['senha_cadcli'];
                    $retorno['data'][$i]['telefone_cadcli'] = $valor['telefone_cadcli'];
                    $retorno['data'][$i]['ramal_cadcli'] = $valor['ramal_cadcli'];
                    $retorno['data'][$i]['celular_cadcli'] = $valor['celular_cadcli'];
                    $retorno['data'][$i]['funcao_cadcli'] = $valor['funcao_cadcli'];
                    $retorno['data'][$i]['status_cadcli'] = $valor['status_cadcli'];
                    $retorno['data'][$i]['cd_caddep'] = $valor['cd_caddep'];
                    $retorno['data'][$i]['cd_cadper'] = $valor['cd_cadper'];
                    $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                    $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['perfis']['id_cadper'] = $valor['id_cadper'];
                    $retorno['data'][$i]['perfis']['desc_cadper'] = $valor['desc_cadper'];
                    $retorno['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                    $retorno['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                    $i ++;
                }
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'admin', 'add', 'cliente');
                /*
                 * Final Log
                */
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("O cadastro não pode ser realizado tente novamente!");
            }
            
            echo json_encode($retorno);
            return $this->getResponse();
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
        // Final do código
    }

    public function deleteAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $id = (int) $data['id_cadcli'];
            $retorno = array();
            $idLogada = $auth->getStorage()->read()->id_cadcli;
            if ($idLogada != $id) {
           
                $delete = $this->getCadcliTable()->deleteCliente($id);
                // print_r($delete);
                // print_r($delete);
                if ($delete == 1) {
                    $retorno['success'] = true;
                    $retorno['message'] = utf8_encode('Usuário excluído com sucesso!');
                    /**
                     * Teste Log
                     */
                    $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                    		->get('Zend\Db\Adapter\Adapter'), 'admin', 'delete', 'cliente');
                    /*
                     * Final Log
                    */
                } else {
                    $retorno['success'] = false;
                    $retorno['message'] = utf8_encode('Existem vínculos relacionados à este usuário.');
                }
            
            }
            else{
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode('Você não pode excluir você mesmo!');
            }
            echo json_encode($retorno);
            return $this->getResponse();
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function listAction ()
    {
        
        // public function validar($serviceLocator,$tableName,$field,$id=null,$valor){
        // print_r($this->RemoteValidate()->validar($this->getCadcliTable(),'cadcli','cpf_cadcli',null,'03531157116',$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')));
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            
            // INICIO DO CÓDIGO
            $dados = array();
            $request = $this->request->getPost();
            $where = null;
            if (isset($request->filter)) {
                $filter = json_decode(stripslashes($request->filter), true);
                if (isset($filter[0]['operator'])) {
                    for ($i = 0; $i < count($filter); $i ++) {
                        $where[] = "cadcli.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
                    }
                } else {
                    $where = null;
                }
            } else {
                $where = null;
            }
            $consulta = $this->getCadcliTable()
                ->fetchAll($where, $request['start'], $request['limit'])
                ->getDataSource();
            $total = (int) $this->getCadcliTable($where)->count();
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
                $dados['data'][$i]['senha_cadcli'] = $valor['senha_cadcli'];
                $dados['data'][$i]['cd_caddep'] = $valor['cd_caddep'];
                $dados['data'][$i]['cd_cadper'] = $valor['cd_cadper'];
                $dados['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                $dados['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                $dados['data'][$i]['perfils']['desc_cadper'] = $valor['desc_cadper'];
                $dados['data'][$i]['perfils']['id_cadper'] = $valor['id_cadper'];
                $dados['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                $dados['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                $i ++;
            }
            
            echo json_encode($dados);
            
            return $this->getResponse();
            // final do codigo
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
            $cadcli = new Cadcli();
            $cadcli->exchangeArray($data);
            $update = $this->getCadcliTable()->updateCliente($cadcli);
            $retorno = array();
            if (is_array($update)) {
                $retorno['success'] = true;
                $retorno['data'] = $update;
                if ($cadcli->status_cadcli == 1) {
                    
                   ($this->enviarEmailAcessoLiberadoAoUsuario($cadcli->id_cadcli));
                 
                }
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'admin', 'update', 'cliente');
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
    /*
     * public function validacaoRemota($field,$value,$id=null){ $request = $this->request->getPost(); $field = trim($field); $value = trim($value); $id = (isset($id)) ? (int) $id : null; $validator = new NoRecordExists( array('table'=>'cadcli','adapter'=>$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),'field'=>$field) ); if($id==null){ if($validator->isValid($value)){ $retorno['success'] = true; } else{ $retorno['success'] = false; } } else{ $count =(int) $this->getCadcliTable()->count($id,$field,$value); if($count>0){ $retorno['success'] = true; } else{ if($validator->isValid($value)){ $retorno['success'] = true; } else{ $retorno['success'] = false; } } } return $retorno; }
     */
    /**
     * Este método tem a função de realizar uma validação remota ele deve receber os seguintes items
     * field:Nome do campo
     * value: Valor do campo
     * idcampo: id opcional
     *
     * @return \Zend\Stdlib\mixed
     */
    public function validateremoteAction ()
    {
        $request = $this->request->getPost();
        $field = trim($request['field']);
        $value = trim($request['value']);
        $id = (isset($request['idcampo'])) ? (int) $request['idcampo'] : null;
        // public function validar($serviceLocator,$tableName,$field,$id=null,$value,$adapter){
        $pluginValidacaoRemota = $this->RemoteValidate()->validar($this->getCadcliTable(), 'cadcli', $field, $id, $value, $this->getServiceLocator()
            ->get('Zend\Db\Adapter\Adapter'));
        // print_r($pluginValidacaoRemota);
        // return $this->getResponse()->setContent(json_encode($this->validacaoRemota($request['field'],$request['value'],$request['id'])));
        return $this->getResponse()->setContent(json_encode($pluginValidacaoRemota));
    }

    public function validatecpfAction ()
    {
        $request = $this->request->getPost();
        $cpf = trim($request['cpf']);
        $valida = $this->Validarcpf()->validar($cpf);
        $id = isset($request['idcampo']) ? (int) $request['idcampo'] : null;
        $validacaoRemota = $this->RemoteValidate()->validar($this->getCadcliTable(), 'cadcli', 'cpf_cadcli', $request['idcampo'], $cpf, $this->getServiceLocator()
            ->get('Zend\Db\Adapter\Adapter'));
        // $validacaoRemota = $this->validacaoRemota('cpf_cadcli', $cpf);
        
        if ($id == null) {
            if ($valida != 1) {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Cpf inválido. Tente novamente");
            } elseif ($validacaoRemota['success'] != 1) {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("O cpf digitado já está cadastrado");
            } else {
                $retorno['success'] = true;
            }
        } else {
            $count = $this->getCadcliTable()->count($id, 'cpf_cadcli', $cpf);
            if ($count > 0) {
                $retorno['success'] = true;
            } else {
                if ($valida != 1) {
                    $retorno['success'] = false;
                    $retorno['message'] = utf8_encode("Cpf inválido. Tente novamente");
                } elseif ($validacaoRemota['success'] != 1) {
                    $retorno['success'] = false;
                    $retorno['message'] = utf8_encode("O cpf digitado já está cadastrado");
                } else {
                    $retorno['success'] = true;
                }
            }
        }
        return $this->getResponse()->setContent(json_encode($retorno));
    }

    public function enviarEmailAcessoLiberadoAoUsuario ($codigoCliente)
    {
        // OBTER INFORMACOES DO USUARIO SOLICITANTE
        $cliente = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->fetchAll("cadcli.id_cadcli = {$codigoCliente}")
            ->getDataSource();
        $nome_cliente = "";
        $departamento_cliente = "";
        $destinatario = "";
        
        foreach ($cliente as $valor) {
            $nome_cliente = utf8_decode($valor['desc_cadcli']);
            $departamento_cliente = utf8_decode($valor['desc_caddep']);
            $email_cliente = $valor['email_cadcli'];
            $destinatario[0]['email'] = $valor['email_cadcli'];
            $destinatario[0]['nomeDestinatario'] = $valor['desc_cadcli'];
            $senha_cliente = $valor['senha_cadcli'];
        }
        // FINAL OBTER INFORMACOES DO USUAIRO SOLICITANTE
        
        // TEXTO DE SOLICITACAO
        $html = "<html><strong>Acesso liberado</strong><br></br> Segue abaixo informações para o acesso ao Sistema de Gerenciamento de Chamados:<br></br>";
        $html .= "Nome: {$nome_cliente} <br></br>";
        $html .= "Email: {$email_cliente} <br></br>";
        $html .= "Senha: {$senha_cliente} <br></br>";
        $html .= "Acesse: <a href=\"http://64.50.182.163/~hepshego/user/index/login\">Módulo Usuário</a></html> <br></br>";
        $html .= "Data atual: ".date('d-m-Y H:i:s');
        
        
        // FINAL DO TEXTO DA SOLICITACAO
        
        // ENVIO DA SOLICITACAO
        $enviarEmail = $this->EnviarEmail()->Envio($destinatario, "Acesso liberado ao Sistema de Gerenciamento de Chamados - Código {$codigoCliente}", $html);
        // print_r($destinatario);
        
        return $enviarEmail;
    }
    
}

?>