<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Admin\Model\Cadsol;
use Admin\Model\Cadaco;
use Zend\Db\ResultSet\ResultSet;
use \PHPMailer;

class TesteController extends AbstractActionController
{

    protected $cadsolTable;

    public function getCadsolTable ()
    {
        if (! $this->cadsolTable) {
            $sm = $this->getServiceLocator()->get('Admin\Model\CadsolTable');
            $this->cadsolTable = $sm;
        }
        return $this->cadsolTable;
    }

    public function indexAction ()
    {
        return $this->getResponse();
    }

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        
        if ($auth->hasIdentity()) {
            $request = $this->getRequest()->getPost();
            $data = json_decode($request->data, true);
            $where = null;
            if (isset($request->filter)) {
                $filter = json_decode(stripslashes($request->filter), true);
                for ($i = 0; $i < count($filter); $i ++) {
                    
                    if ($filter[$i]['id'] == "buscaPorPeriodo") {
                        $where[] = " (viewsolicitacoes.{$filter[$i]['property']} between '{$filter[$i]['from']}' and '{$filter[$i]['to']}') OR (viewsolicitacoes.{$filter[$i]['property']} between '{$filter[$i]['from']}' and '{$filter[$i]['to']}') ";
                    }
                    if ($filter[$i]['id'] == "status") {
                        if ($filter[$i]['property'] != "" && $filter[$i]['value'] != null) {
                            $where[] = "viewsolicitacoes.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
                        }
                    }
                }
            } else {
                $where = null;
            }
            if (isset($request->sort)) {
                $sort = json_decode($request->sort, true);
                $property = $sort[0]['property'];
                $direction = $sort[0]['direction'];
                $order = "viewsolicitacoes.{$property} {$direction}";
            } else {
                $order = null;
            }
            $limit = (int) $request['limit'];
            $start = (int) $request['start'];
            $consulta = $this->getCadsolTable()->fetchAll($where, $start, $limit);
            
            $retorno['total'] = $this->getCadsolTable()
                ->fetchAll($where)
                ->count();
            
            $i = 0;
            if ($retorno['total'] > 0) {
                $rows = new ResultSet();
                foreach ($rows->initialize($consulta)->toArray() as $valor) {
                    $retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
                    $retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
                    $retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
                    $retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
                    $retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
                    $retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
                    $retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];
                    $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                    $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
                    
                    $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                    $retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
                    $retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
                    $retorno['data'][$i]['atendente'] = $valor['atendente'];
                    $retorno['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                    $retorno['data'][$i]['tempo_execucao'] = $valor['tempo_execucao'];
                    // $retorno['data'][$i]['tempo_execucao'] = 2;
                    /*
                     * if ($valor['cd_cadsta'] == 4) { if ($valor['tempo_gasto'] < 1440) { if ($valor['tempo_gasto'] > 60) { $hora = (int) ($valor['tempo_gasto'] / 60); $minutos = (int) ($valor['tempo_gasto'] % 60); $retorno['data'][$i]['tempo_gasto'] = "Tempo utilizado: {$hora} horas"; } else { $retorno['data'][$i]['tempo_gasto'] = "Tempo utilizado: {$valor['tempo_gasto']} minutos"; } } else { $t = (int) ($valor['tempo_gasto'] / 60); $dias = (int) $t / 24; $dias = (int) $dias; $retorno['data'][$i]['tempo_gasto'] = "Tempo utilizado: {$dias} dias"; } } else { $retorno['data'][$i]['tempo_gasto'] = utf8_encode("Esta solicitação ainda não foi fechada"); }
                     */
                    $retorno['data'][$i]['tempo_gasto'] = $valor['tempo_gasto'];
                    $i ++;
                }
                $retorno['success'] = true;
            } else {
                $retorno['success'] = true;
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            
            return false;
        }
    }

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $data = json_decode($request->data, true);
            $cadsol = new Cadsol();
            $cadsol->exchangeArray($data);
            $insert = $this->getCadsolTable()->saveSolicitacao($cadsol);
            // ENVIAR EMAIL PARA O TÉCNICO
            $this->enviarEmailTecnico($insert, $cadsol->cd_cadser, $cadsol->cd_cadcli, $cadsol->data_cadsol);
            // FINAL ENVIAR EMAIL PARA O TÉCNICO
            $retorno = array();
            $i = 0;
            if ($insert > 0) {
                // Adicicionar um acompanhamento com o status de novo
                $service = $this->getServiceLocator()->get('Admin\Model\CadacoTable');
                $cadaco = new Cadaco();
                $dados['cd_cadsol'] = $insert;
                $dados['cd_cadcli'] = $data['cd_cadcli'];
                $dados['cd_cadsta'] = 1;
                $dados['desc_cadaco'] = utf8_encode("Solicitação aberta.");
                $dados['atualizacao_cadaco'] = $data['data_cadsol'];
                $cadaco->exchangeArray($dados);
                $service->saveAcompanhamento($cadaco);
                $consulta = $this->getCadsolTable()->fetchAll(array(
                    "viewsolicitacoes.id_cadsol={$insert}"
                ));
                $rows = new ResultSet();
                foreach ($rows->initialize($consulta)->toArray() as $valor) {
                    $retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
                    $retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
                    $retorno['data'][$i]['cd_cadcli'] = $valor['cd_cadcli'];
                    $retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
                    $retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
                    $retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
                    $retorno['data'][$i]['prioridades']['desc_cadpri'] = $valor['desc_cadpri'];
                    $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                    $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
                    $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                    $retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
                    $retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
                    $retorno['data'][$i]['tempo_execucao'] = $valor['tempo_execucao'];
                    $retorno['data'][$i]['atendente'] = $valor['atendente'];
                    $retorno['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                    $i ++;
                }
                
                $retorno['success'] = true;
            } else {
                $retorno['success'] = false;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
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
            $request = $this->request->getPost();
            $data = json_decode($request->data, true);
            $id_cadsol = $data['id_cadsol'];
            // Excluir os acompanhamentos
            $where = "cadaco.cd_cadsol = {$id_cadsol}";
            $deleteAcompanhamentos = $this->getServiceLocator()
                ->get('Admin\Model\CadacoTable')
                ->deleteAcompanhamento($where);
            
            // Final excluir os acompanhamentos
            // Inicio excluir a solicitacao
            $deleteSolicitacao = $this->getCadsolTable()->deleteSolicitacao($id_cadsol);
            if ($deleteSolicitacao) {
                $retorno['success'] = true;
                $retorno['message'] = utf8_encode("Solicitacação excluída com sucesso");
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Solicitacação não excluída tente novamente!");
            }
            // Final excluir a solicitacao
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function relatorioquantidadesolicitacoesAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $consulta = $this->getCadsolTable()
                ->RelatorioQuantidadeSolicitacoes()
                ->getDataSource();
            $retorno = array();
            $i = 0;
            foreach ($consulta as $valor) {
                $retorno['data'][$i]['desc_cadsta'] = $valor['desc_cadsta'];
                $retorno['data'][$i]['total'] = $valor['total'];
                $i ++;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function solicitacoesporperiodoAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $consulta = $this->getCadsolTable()->solicitacoesPorPeriodo();
            // print_r($consulta);
            $row = new ResultSet();
            $retorno['success'] = true;
            $i = 0;
            foreach ($row->initialize($consulta)->toArray() as $valor) {
                $retorno['data'][$i]['total'] = $valor['total'];
                $retorno['data'][$i]['descricao'] = $valor['desc_cadser'];
                $i ++;
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('login');
        }
    }

    public function qtdsolicitacoespusuarioAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $consulta = $this->getCadsolTable($request['start'], $request['limit'])->solicitacoesPorUsuario();
            $retorno = array();
            $row = new ResultSet();
            $i = 0;
            foreach ($row->initialize($consulta)->toArray() as $valor) {
                $retorno['data'][$i]['chamados'] = $valor['Chamados'];
                $retorno['data'][$i]['usuario'] = $valor['Usuario'];
                $i ++;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            return false;
        }
    }

    public function solicitacoesmaisfrequentesAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $consulta = $this->getCadsolTable($request['start'], $request['limit'])->solicitacoesmaisFrequentes();
            $retorno = array();
            $row = new ResultSet();
            $i = 0;
            foreach ($row->initialize($consulta)->toArray() as $valor) {
                $retorno['data'][$i]['servico'] = $valor['desc_cadser'];
                $retorno['data'][$i]['quantidade'] = $valor['quantidade'];
                $i ++;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            return false;
        }
    }

    public function enviarEmailTecnico ($codigoSolicitacao, $codigoServico, $codigoCliente, $dateHora)
    {
        // OBTER DESCRICAO DO SERVICO//
        $servico = $this->getServiceLocator()
            ->get('Admin\Model\CadserTable')
            ->fetchAll("cadser.id_cadser = {$codigoServico}")
            ->getDataSource();
        $descricao_servico = "";
        foreach ($servico as $valor) {
            $descricao_servico = html_entity_decode($valor['desc_cadser']);
            $grupo = $valor['cd_caddir'];
        }
        // FINAL DESCRICAO DE SERVICO//
        
        // OBTER INFORMACOES DO USUARIO SOLICITANTE
        $cliente = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->fetchAll("cadcli.id_cadcli = {$codigoCliente}")
            ->getDataSource();
        $nome_cliente = "";
        $departamento_cliente = "";
        foreach ($cliente as $valor) {
            $nome_cliente = $valor['desc_cadcli'];
            $departamento_cliente = html_entity_decode($valor['desc_caddep']);
        }
        // FINAL OBTER INFORMACOES DO USUAIRO SOLICITANTE
        
        // OBTER INFORMACOES ATENDENNTE
        $atendente = $this->getServiceLocator()
            ->get('Admin\Model\CadcliTable')
            ->fetchAll("cadcli.cd_caddir = {$grupo}")
            ->getDataSource();
        
        $nome_atendente = "";
        $email_atendente = "";
        $i = 0;
        $destinatario = "";
        foreach ($atendente as $valor) {
            $destinatario[$i]['email'] = $valor['email_cadcli'];
            $destinatario[$i]['nomeDestinatario'] = $valor['desc_cadcli'];
            $i ++;
        }
        // FINAL OBTER INFORMACOES ATENDENTE
        // TEXTO DE SOLICITACAO
        $html = "<html><strong>Uma nova solicitação foi aberta</strong><br></br> Segue abaixo informações da solicitação para mais detalhes:<br></br>";
        
        $html .= "Código da solicitacão: {$codigoSolicitacao} <br></br>";
        $html .= "Tipo de servico: {$descricao_servico} <br></br>";
        $html .= "Solicitante: {$nome_cliente} <br></br>";
        $html .= "Departamento: {$departamento_cliente} <br></br>";
        $html .= "Data de abertura: {$dateHora}<br></br>";
        $html .= "Para mais detalhes da solicitação. Acesse o módulo técnico do sistema: <a href=\"http://64.50.182.163/~hepshego/tecnico/login\">Módulo Técnico</a></html>";
        
        // FINAL DO TEXTO DA SOLICITACAO
        
        // ENVIO DA SOLICITACAO
        $enviarEmail = $this->EnviarEmail()->Envio($destinatario, "Abertura de Nova Solicitação - Código {$codigoSolicitacao}", $html);
        
        return $this->getResponse()->setContent($enviarEmail);
    }

    public function tempomediosolicitacaoAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('admin'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();
            $start = (isset($request['start'])) ? (int) $request['start'] : 0;
            $limit = (isset($request['limit'])) ? (int) $request['limit'] : 25;
            
            $consulta = $this->getCadsolTable()->TempoMedioSolicitacoes(null, $start, $limit);
            
            $retorno = array();
            $row = new ResultSet();
            $i = 0;
            foreach ($row->initialize($consulta)->toArray() as $valor) {
                $retorno['data'][$i]['desc_cadser'] = $valor['desc_cadser'];
                $retorno['data'][$i]['tempo_execucao'] = $valor['tempo_execucao'];
                $i ++;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            return false;
        }
    }
}

?>

