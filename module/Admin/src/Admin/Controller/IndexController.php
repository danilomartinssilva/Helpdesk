<?php
namespace Admin\Controller;

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
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $viewModel = new ViewModel();
            $viewModel->setTerminal(true);
            return $viewModel;
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
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
        // $response = $this->getResponse();
        $dbAdapter = $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter');
        $authAdaptor = new AuthAdapter($dbAdapter);
        $authAdaptor->setTableName("cadcli")
            ->setIdentityColumn("email_cadcli")
            ->setCredentialColumn("senha_cadcli");
        $authAdaptor->setIdentity($email);
        $authAdaptor->getDbSelect()->where(array(
            'cadcli.cd_cadper' => 1
        ));
        $authAdaptor->setCredential($senha);
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        $result = $auth->authenticate($authAdaptor);
        if ($result->isValid()) {
            $storage = $auth->getStorage();
            $storage->write($authAdaptor->getResultRowObject(array(
                "desc_cadcli",
                "email_cadcli",
                "id_cadcli"
            )));
            $dados['success'] = true;
            $dados['message'] = "PASSOU";
        } else {
            $dados['success'] = false;
            $dados['message'] = utf8_encode("Login e/ou senha inválidos ou você pode não possuir acesso permitido á este módulo.");
        }
        return $this->response->setContent(json_encode($dados));
    }

    public function headerAction ()
    {
        $auth = new AuthenticationService();
        if ($auth->setStorage(new Session('admin'))) :
             $url =__DIR__;
            $endereco = "";
            if(substr_count($url,"HelpDesk")>0){
            	$endereco = "/helpdesk/public/";
            	 
            }
            else{
            	$endereco = "/~hepshego/";
            }
            $url = $endereco;
            $storage = $auth->getStorage();
            $nomeAdministrador = $storage->read()->desc_cadcli;
            $idAdministrador = $storage->read()->id_cadcli;
            $dataServer = array(                
                'desc_cadcli' =>($nomeAdministrador),
                'id_cadcli' =>($idAdministrador),
                'url'=>($endereco)    
            );
            $json = json_encode($dataServer);
            echo "window.dataServerUsuario ={$json}";
            return $this->getResponse();
        
            
    	endif;
    }

    public function logoutAction ()
    {
        $response = $this->getResponse();
        $auth = new AuthenticationService();
        if ($auth->setStorage(new Session('admin'))) {
            $auth->clearIdentity();
            $dados['success'] = true;
            echo json_encode($dados);
        }
        return $response;
    }
    /*
     * var store = Ext.create('Ext.data.TreeStore', { root: { expanded: true, children: [ { text:'Rotinas',iconCls:'icone_listar',id:'rotinas',expanded:false,children:[ { text:'Acompanhamento',id:'lisaco',leaf:true,iconCls:'icone_lupa' }, { text:'Chamados',id:'lissol',leaf:true,iconCls:'icone_chamados' },{ text:'Catálogo de serviços',iconCls:'icone_pendencia',leaf:true,id:'lisser' },{ text:'Gerenciar departamentos',iconCls:'icone_departamento',leaf:true,id:'lisdep' },{ text:'Gerenciar usuários',iconCls:'icone_clientes',leaf:true,id:'liscli' },{ text:'Direcionador',iconCls:'icone_clientes',leaf:true,id:'lisdir' }] }, { text:'Administração',iconCls:'icone_administracao',id:'administracao',expanded:false, } ] } });
     */
    public function menuAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            // Solicitações
            $menu['data'][0]['id'] = utf8_encode('Solicitações');
            $menu['data'][0]['iconCls'] = 'icone_chamados';
            $menu['data'][0]['leaf'] = true;
            $menu['data'][0]['expanded'] = true;
            $menu['data'][0]['children'][0]['id'] = "lissol";
            $menu['data'][0]['children'][0]['text'] = "Listar chamados";
            $menu['data'][0]['children'][0]['leaf'] = true;
            $menu['data'][0]['children'][1]['id'] = "lisranking";
            $menu['data'][0]['children'][1]['text'] = utf8_encode("Usuários com mais solicitações");
            $menu['data'][0]['children'][1]['leaf'] = true;
            $menu['data'][0]['children'][2]['id'] = "lissolfrequencia";
            $menu['data'][0]['children'][2]['text'] = utf8_encode("Principais solicitações");
            $menu['data'][0]['children'][2]['leaf'] = true;
            $menu['data'][0]['children'][3]['id'] = "listempomedio";
            $menu['data'][0]['children'][3]['text'] = utf8_encode("Tempo médio das solicitações");
            $menu['data'][0]['children'][3]['leaf'] = true;
            
            
            
            // Departamento
            $menu['data'][1]['id'] = 'Departamentos';
            $menu['data'][1]['iconCls'] = 'icone_departamento';
            $menu['data'][1]['leaf'] = true;
            $menu['data'][1]['expanded'] = true;
            $menu['data'][1]['children']['id'] = "lisdep";
            $menu['data'][1]['children']['text'] = "Listar Departamentos";
            $menu['data'][1]['children']['leaf'] = true;
            
            // Serviços
            $menu['data'][2]['id'] = utf8_encode('Serviços');
            $menu['data'][2]['iconCls'] = 'icone_pendencia';
            $menu['data'][2]['leaf'] = true;
            $menu['data'][2]['expanded'] = true;
            $menu['data'][2]['children']['id'] = "lisser";
            $menu['data'][2]['children']['text'] = utf8_encode("Listar Catálogo de Serviços");
            $menu['data'][2]['children']['leaf'] = true;
            
            // Clientes
            $menu['data'][3]['id'] = utf8_encode('Usuário');
            $menu['data'][3]['iconCls'] = 'icone_clientes';
            $menu['data'][3]['leaf'] = true;
            $menu['data'][3]['expanded'] = true;
            $menu['data'][3]['children']['id'] = "liscli";
            $menu['data'][3]['children']['text'] = "Listar Clientes";
            $menu['data'][3]['children']['leaf'] = true;
            
           
            
           // Administração
            $menu['data'][4]['id'] = utf8_encode('Administração');
            $menu['data'][4]['iconCls'] = 'icone_administracao';
            $menu['data'][4]['leaf'] = true;
            $menu['data'][4]['expanded'] = true;
            $menu['data'][4]['children']['id'] = "lislog";
            $menu['data'][4]['children']['text'] = "Acomapanhar Logs";
            $menu['data'][4]['children']['leaf'] = true;
            
            
            
            
            // Direcionamento
            $menu['data'][5]['id'] = utf8_encode('Grupos');
            $menu['data'][5]['iconCls'] = 'icone_direcionamento';
            $menu['data'][5]['leaf'] = true;
            $menu['data'][5]['expanded'] = true;
            $menu['data'][5]['children']['id'] = "lisdir";
            $menu['data'][5]['children']['text'] = "Listar Direcionamento";
            $menu['data'][5]['children']['leaf'] = true;
            
            // Basede Conhecimento
            $menu['data'][6]['id'] = utf8_encode('Base de Conhecimento');
            $menu['data'][6]['iconCls'] = 'icone_direcionamento';
            $menu['data'][6]['leaf'] = true;
            $menu['data'][6]['expanded'] = true;
            $menu['data'][6]['children'][0]['id'] = "cadbase";
            $menu['data'][6]['children'][0]['text'] = utf8_encode("Cadastrar Título");
            $menu['data'][6]['children'][0]['leaf'] = true;
            $menu['data'][6]['children'][1]['id'] = "lisbase";
            $menu['data'][6]['children'][1]['text'] = utf8_encode("Listar todos os títulos");
            $menu['data'][6]['children'][1]['leaf'] = true;
            
            /*
             * $menu['data'][3]['children']['id'] = "liscli"; $menu['data'][3]['children']['text'] = "Listar Clientes"; $menu['data'][3]['children']['leaf'] = true;
             */
            
            return $this->getResponse()->setContent(json_encode($menu));
    		
    	}
    	else{
    		$auth->clearIdentity();
            $this->redirect()->toRoute('login');
    	}
        
    }

}