<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadser;
use PHPPdf\Autoloader;
define('DOMPDF_ENABLE_AUTOLOAD', false);
use PHPPdf;

class ServicosController extends AbstractActionController
{

    protected $cadserTable;

    public function getCadserTable ()
    {
        if (! $this->cadserTable) {
            $sm = $this->serviceLocator->get('Admin\Model\CadserTable');
            $this->cadserTable = $sm;
        }
        return $this->cadserTable;
    }

    public function indexAction ()
    {
        return $this->getResponse();
    }

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode( stripslashes($request->data), true);
            $cadser = new Cadser();
            $cadser->exchangeArray($data);
            $insert = $this->getCadserTable()->saveServico($cadser);
            if ($insert > 0) {
                $where = "cadser.id_cadser = {$insert}";
                $consulta = $this->getCadserTable()
                    ->fetchAll()
                    ->getDataSource();
                $retorno['success'] = true;
                $i = 0;
                foreach ($consulta as $valor) {
                    $retorno['data'][$i]['prioridades']['id_cadpri'] = $valor['id_cadpri'];
                    $retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];
                    $retorno['data'][$i]['prioridades']['componente_cadpri'] = $valor['componente_cadpri'];
                    $retorno['data'][$i]['prioridades']['tempo_cadpri'] = $valor['tempo_cadpri'];
                    $retorno['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
                    $retorno['data'][$i]['id_cadser'] = $valor['id_cadser'];
                    $retorno['data'][$i]['obs_cadser'] = $valor['obs_cadser'];
                    $retorno['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                    $retorno['data'][$i]['cd_cadpri'] = $valor['cd_cadpri'];
                    $retorno['data'][$i]['parent_cadser'] = $valor['parent_cadser'];
                    $retorno['data'][$i]['categorias']['id'] = $valor['id'];
                    $retorno['data'][$i]['categorias']['descricao'] = $valor['descricao'];
                    $retorno['data'][$i]['tempo_cadser'] = $valor['tempo_cadser'];
                }
                
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'admin', 'insert', 'servicos');
                /*
                 * Final Log
                */
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Não foi possível cadastrar este no catálogo de serviços");
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
            $data = json_decode( stripslashes( $request->data), true);            
            $cadser = new Cadser();
            $cadser->exchangeArray($data);
            // print_r($cadser);
            $update = $this->getCadserTable()->updateServico($cadser);
            // print_r($update);
            if ($update) {
                $consulta = $this->getCadserTable()
                    ->fetchAll("cadser.id_cadser = {$cadser->id_cadser}")
                    ->getDataSource();
                $retorno['success'] = true;
                $i = 0;
                foreach ($consulta as $valor) {
                    $retorno['data'][$i]['prioridades']['id_cadpri'] = $valor['id_cadpri'];
                    $retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];
                    $retorno['data'][$i]['prioridades']['componente_cadpri'] = $valor['componente_cadpri'];
                    $retorno['data'][$i]['prioridades']['tempo_cadpri'] = $valor['tempo_cadpri'];
                    $retorno['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
                    $retorno['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                    $retorno['data'][$i]['id_cadser'] = $valor['id_cadser'];
                    $retorno['data'][$i]['obs_cadser'] = $valor['obs_cadser'];
                    $retorno['data'][$i]['cd_cadpri'] = $valor['cd_cadpri'];
                    $retorno['data'][$i]['parent_cadser'] = $valor['parent_cadser'];
                    $retorno['data'][$i]['categorias']['id'] = $valor['id'];
                    $retorno['data'][$i]['categorias']['descricao'] = $valor['descricao'];
                    $retorno['data'][$i]['tempo_cadser'] = $valor['tempo_cadser'];
                }
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'admin', 'update', 'servicos');
                /*
                 * Final Log
                */
                
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Não foi possível realizar a atualização de dados.");
            }
            echo json_encode($retorno);
            return $this->getResponse();
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function deleteAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->getRequest()->getPost();
            $data = json_decode(stripslashes($request->data), true);
            // print_r($data);
            $id = (int) $data['id_cadser'];
            $delete = $this->getCadserTable()->deleteServico($id);
            $retorno = array();
            if ($delete == 1) {
                $retorno['success'] = true;
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'admin', 'delete', 'servicos');
                /*
                 * Final Log
                */
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode('Este serviço está sendo vinculado à algum outro registro atualmente!');
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            
            $request = $this->getRequest()->getPost();
            $where = null;
            if (isset($request->filter)) {
                $filter = json_decode(stripslashes($request->filter), true);
                if (isset($filter[0]['operator'])) {
                    for ($i = 0; $i < count($filter); $i ++) {
                        $where[] = "cadser.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
                    }
                } else {
                    $where = null;
                }
            } else {
                $where = null;
            }
            $data = json_decode($request->data, true);
            $consulta = $this->getCadserTable()
                ->fetchAll($where)
                ->getDataSource();
            $count = $this->getCadserTable()->count($where);
            $dados = array();
            $dados['total'] = (int) $count;
            $dados['success'] = true;
            $i = 0;
            foreach ($consulta as $valor) {
                $dados['data'][$i]['prioridades']['id_cadpri'] = $valor['id_cadpri'];
                $dados['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];
                $dados['data'][$i]['prioridades']['componente_cadpri'] = $valor['componente_cadpri'];
                $dados['data'][$i]['prioridades']['tempo_cadpri'] = $valor['tempo_cadpri'];
                $dados['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
                $dados['data'][$i]['id_cadser'] = $valor['id_cadser'];
                $dados['data'][$i]['obs_cadser'] = $valor['obs_cadser'];
                $dados['data'][$i]['cd_caddir'] = $valor['cd_caddir'];
                $dados['data'][$i]['cd_cadpri'] = $valor['cd_cadpri'];
                $dados['data'][$i]['parent_cadser'] = $valor['parent_cadser'];
                $dados['data'][$i]['categorias']['id'] = $valor['id'];
                $dados['data'][$i]['categorias']['descricao'] = $valor['descricao'];
                $dados['data'][$i]['tempo_cadser'] = $valor['tempo_cadser'];
                
                $i ++;
            }
            return $this->getResponse()->setContent(json_encode($dados));
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
            $request = $this->getRequest()->getPost();
            $field = trim($request['field']);
            $value = trim($request['value']);
            $id = (isset($request['idcampo'])) ? (int) $request['idcampo'] : null;
            $pluginValidacaoRemota = $this->RemoteValidate()->validar($this->getCadserTable(), 'cadser', $field, $id, $value, $this->getServiceLocator()
                ->get('Zend\Db\Adapter\Adapter'));
            return $this->getResponse()->setContent(json_encode($pluginValidacaoRemota));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function gerarpdfAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->getRequest()->getPost();
            $data = json_decode($request->data, true);
            $consulta = $this->getCadserTable()
                ->fetchAll()
                ->getDataSource();
            $dados = array();
            $html = '                
                <html>
                <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"><title>Data Tables and Cascading Style Sheets Gallery</title><link rel="stylesheet" href="../csstg.css" type="text/css"><style>
        table {
                width:100%;
          border-collapse: collapse;
          border: 2px solid #996;
          font: normal 80%/140% verdana, arial, helvetica, sans-serif;
          color: #333;
          background: #fffff0;
          }
        caption {
          padding: 0 .4em .4em;
          text-align: left;
          font-size: 1em;
          font-weight: bold;
          text-transform: uppercase;
          color: #333;
          background: transparent;
          }
        td, th {
          border: 1px solid #cc9;
          padding: .3em;
          }
        thead th, tfoot th {
          border: 1px solid #cc9;
          text-align: left;
          font-size: 1em;
          font-weight: bold;
          color: #444;
          background: #dbd9c0;
          }
        tbody td a {
          background: transparent;
          color: #72724c;
          text-decoration: none;
          border-bottom: 1px dotted #cc9;
          }
        tbody td a:hover {
          background: transparent;
          color: #666;
          border-bottom: 1px dotted #72724c;
          }
        tbody th a {
          background: transparent;
          color: #72724c;
          text-decoration: none;
          font-weight:bold;
          border-bottom: 1px dotted #cc9;
          }
        tbody th a:hover {
          background: transparent;
          color: #666;
          border-bottom: 1px dotted #72724c;
          }
        tbody th, tbody td {
          vertical-align: top;
          text-align: left;
          }
        tfoot td {
          border: 1px solid #996;
          }
        .odd {
          color: #333;
          background: #f7f5dc;
          }
        tbody tr:hover {
          color: #333;
          background: #fff;
          }
        tbody tr:hover th,
        tbody tr.odd:hover th {
          color: #333;
          background: #ddd59b;
          }                
        </style></head>
                        
                        <body>
                        <table>
                        <tr>
                        <td colspan="4" style="text-align:center;"><b>' . htmlentities('Descrição dos Serviços') . '</b></td>
                        </tr>                         
                        <tr>
                        <td>' . htmlentities('Descrição do Serviço') . '</td>
                                                
                        <td>Prioridade</td>
                        <td>' . htmlentities('Tempo de Execução') . '</td>
                        <td>Categoria</td>                
                        </tr>';
            $i = 0;
            $table = "";
            foreach ($consulta as $valor) {
                $table .= "<tr>
                    <td>{$valor['desc_cadser']}</td>                    
                    <td>{$valor['desc_cadpri']}</td>
                    <td>{$valor['tempo_cadpri']}</td>
                    <td>{$valor['descricao']}</td>
                </tr>";
                // echo $table;
                $i ++;
            }
            
            $html .= $table . '</table></body></html>';
            // echo $html;
            // /echo $html;
            echo $this->generatePdf($html);
            return $this->getResponse();
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function generatePdf ($html,$attachment=0){
        require_once '/vendor/dompdf/dompdf/dompdf_config.inc.php';        
        $dompdf = new \DOMPDF();
        $dompdf->load_html($html);
        $dompdf->render();
        //$dompdf->stream(date('YmdHis.pdf'),array('attachment'=>1));
        $dompdf->stream(date('YmdHis'),array('attachment'=>0));        
    }
    
    
    
    
}

?>