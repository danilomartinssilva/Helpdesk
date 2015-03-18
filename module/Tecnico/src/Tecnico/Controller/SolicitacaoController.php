<?php
namespace Tecnico\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Db\ResultSet\ResultSet;
use Admin\Model\Cadsol;
use Admin\Model\Cadaco;
use Admin\Controller\Plugin\GerarLog;

class SolicitacaoController extends AbstractActionController
{

    public function listAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            $request = $this->getRequest()->getPost();
            $data = json_decode(stripslashes($request->data), true);
            $codigoDirecionamento = $auth->getStorage()->read()->cd_caddir;
            
            if (isset($request->filter)) {
                $filter = json_decode(stripslashes($request->filter), true);
                for ($i = 0; $i < count($filter); $i ++) {
                    $where[] = "viewsolicitacoestecnico.{$filter[$i]['property']} {$filter[$i]['operator']} {$filter[$i]['value']}";
                }
            } else {
                $where = null;
            }
            $where[] = "viewsolicitacoestecnico.id_caddir = {$codigoDirecionamento}";
            
            if (isset($request->sort)) {
                $sort = json_decode($request->sort, true);
                $property = $sort[0]['property'];
                $direction = $sort[0]['direction'];
                $order = "viewsolicitacoestecnico.{$property} {$direction}";
            } else {
                $order = null;
            }
            $limit = (int) $request['limit'];
            $start = (int) $request['start'];
            $consulta = $this->getServiceLocator()
                ->get('Admin\Model\CadsolTable')
                ->fetchAllTecnico($where, $start, $limit);
            $retorno['total'] = $this->getServiceLocator()
                ->get('Admin\Model\CadsolTable')
                ->fetchAllTecnico($where)
                ->count();
            
            $i = 0;
            if ($retorno['total'] > 0) {
                $rows = new ResultSet();
                foreach ($rows->initialize($consulta)->toArray() as $valor) {
                    $retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
                    $retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
                    $retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
                    $retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
                    $retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
                    $retorno['data'][$i]['cd_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                    $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
                    $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                    $retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
                    $retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
                    $retorno['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                    $retorno['data'][$i]['atendente'] = $valor['atendente'];
                    
                    if ($valor['cd_cadsta'] == 4) {
                        if ($valor['tempo_execucao'] < 1440) {
                            if ($valor['tempo_execucao'] > 60) {
                                $hora = (int) ($valor['tempo_execucao'] / 60);
                                $minutos = (int) ($valor['tempo_execucao'] % 60);
                                $retorno['data'][$i]['tempo_execucao'] = "Tempo utilizado: {$hora} horas";
                            } else {
                                $retorno['data'][$i]['tempo_execucao'] = "Tempo utilizado: {$valor['tempo_execucao']} minutos";
                            }
                        } else {
                            $t = (int) ($valor['tempo_execucao'] / 60);
                            $dias = (int) $t / 24;
                            $dias = (int) $dias;
                            
                            $retorno['data'][$i]['tempo_execucao'] = "Tempo utilizado: {$dias} dias";
                        }
                    } else {
                        $retorno['data'][$i]['tempo_execucao'] = utf8_encode("Esta solicitação ainda não foi fechada");
                    }
                    $i ++;
                }
                $retorno['success'] = true;
            } else {
                $retorno['success'] = true;
            }
            
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('logintecnico');
        }
    }

    public function addAction ()
    {
        $auth = new AuthenticationService();
        $auth->setStorage(new Session('tecnico'));
        if ($auth->hasIdentity()) {
            $request = $this->request->getPost();            
            $data = json_decode(stripslashes($request->data), true);
            $cadsol = new Cadsol();
            $cadsol->exchangeArray($data);
            
            $insert = $this->getServiceLocator()
                ->get('Admin\Model\CadsolTable')
                ->saveSolicitacao($cadsol);
            if ($insert > 0) {
                $service = $this->getServiceLocator()->get('Admin\Model\CadacoTable');
                $cadaco = new Cadaco();                
                $dados['cd_cadsol'] = $insert;
                $dados['cd_cadcli'] = $data['cd_cadcli'];
                $dados['cd_cadsta'] = 1;
                $dados['desc_cadaco'] = utf8_encode("Solicitação aberta.");
                $dados['atualizacao_cadaco'] = $data['data_cadsol'];                
                $cadaco->exchangeArray($dados);
                $service->saveAcompanhamento($cadaco);
                //ENVIO EMAIL
                $this->enviarEmailTecnico($insert, $cadsol->cd_cadser,$cadsol->cd_cadcli, $cadsol->data_cadsol);
                // FINAL ENVIO EMAIL PARA TÉCNICO
                $retorno['success'] = true;
                $retorno['message'] = utf8_encode("Solicitação cadastrada com sucesso!");
                $where = array(
                    "viewsolicitacoestecnico.id_cadsol = {$insert}"
                );
                $consulta = $this->getServiceLocator()
                ->get('Admin\Model\CadsolTable')
                ->fetchAllTecnico($where);             
                $i = 0;
                $rows = new ResultSet();
                foreach ($rows->initialize($consulta)->toArray() as $valor) {
                    $retorno['data'][$i]['id_cadsol'] = $valor['id_cadsol'];
                    $retorno['data'][$i]['desc_cadsol'] = $valor['desc_cadsol'];
                    $retorno['data'][$i]['data_cadsol'] = $valor['data_cadsol'];
                    $retorno['data'][$i]['clientes']['desc_cadcli'] = $valor['desc_cadcli'];
                    $retorno['data'][$i]['clientes']['id_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['cd_cadser'] = $valor['cd_cadser'];
                    $retorno['data'][$i]['cd_cadcli'] = $valor['id_cadcli'];
                    $retorno['data'][$i]['departamentos']['desc_caddep'] = $valor['desc_caddep'];
                    $retorno['data'][$i]['departamentos']['id_caddep'] = $valor['id_caddep'];
                    $retorno['data'][$i]['servicos']['desc_cadser'] = $valor['desc_cadser'];
                    $retorno['data'][$i]['cd_cadsta'] = $valor['cd_cadsta'];
                    $retorno['data'][$i]['statuss']['desc_cadsta'] = $valor['desc_cadsta'];
                    $retorno['data'][$i]['statuss']['id_cadsta'] = $valor['id_cadsta'];
                    $retorno['data'][$i]['direcionamentos']['descricao_caddir'] = $valor['descricao_caddir'];
                    $retorno['data'][$i]['atendente'] = $valor['atendente'];
                    $i ++;
                }
                
                /**
                 * Teste Log
                 */
                $gerarLog = $this->GerarLog()->log($this->getServiceLocator()
                		->get('Zend\Db\Adapter\Adapter'), 'tecnico', 'insert', 'solicitacao');
                /*
                 * Final Log
                */
            } else {
                $retorno['success'] = false;
                $retorno['message'] = utf8_encode("Solicitação não cadastrada " . $insert);
            }
            return $this->getResponse()->setContent(json_encode($retorno));
        } else {
            $auth->clearIdentity();
            $this->redirect()->toRoute('logintecnico');
        }
    }
    public function enviarEmailTecnico($codigoSolicitacao,$codigoServico,$codigoCliente,$dateHora){
    	//OBTER DESCRICAO DO SERVICO//
    	$servico = $this->getServiceLocator()->get('Admin\Model\CadserTable')->fetchAll("cadser.id_cadser = {$codigoServico}")->getDataSource();
    	$descricao_servico = "";
    	foreach($servico as $valor){
    		$descricao_servico = html_entity_decode($valor['desc_cadser']);
    		$grupo = $valor['cd_caddir'];
    	}
    	//FINAL DESCRICAO DE SERVICO//
    
    	//OBTER INFORMACOES DO USUARIO SOLICITANTE
    	$cliente = $this->getServiceLocator()->get('Admin\Model\CadcliTable')->fetchAll("cadcli.id_cadcli = {$codigoCliente}")->getDataSource();
    	$nome_cliente = "";
    	$departamento_cliente = "";
    	foreach($cliente as $valor){
    		$nome_cliente = $valor['desc_cadcli'];
    		$departamento_cliente = html_entity_decode($valor['desc_caddep']);
    	}
    	// FINAL OBTER INFORMACOES DO USUAIRO SOLICITANTE
    
    	//OBTER INFORMACOES ATENDENNTE
    	$atendente = $this->getServiceLocator()->get('Admin\Model\CadcliTable')->fetchAll("cadcli.cd_caddir = {$grupo}")->getDataSource();
    
    	$nome_atendente = "";
    	$email_atendente = "";
    	$i=0;
    	$destinatario="";
    	foreach($atendente as $valor){
    		$destinatario[$i]['email'] = $valor['email_cadcli'];
    		$destinatario[$i]['nomeDestinatario'] = $valor['desc_cadcli'];
    		$i++;
    
    	}
    	//FINAL OBTER INFORMACOES ATENDENTE
    	//TEXTO DE SOLICITACAO
    	$html = "<html><strong>Uma nova solicitação foi aberta</strong><br></br> Segue abaixo informações da solicitação para mais detalhes:<br></br>";
    
    	$html.="Código da solicitacão: {$codigoSolicitacao} <br></br>";
    	$html.="Tipo de servico: {$descricao_servico} <br></br>";
    	$html.="Solicitante: {$nome_cliente} <br></br>";
    	$html.="Departamento: {$departamento_cliente} <br></br>";
    	$html.="Data de abertura: {$dateHora}<br></br>";
    	$html.="Para mais detalhes da solicitação. Acesse o módulo técnico do sistema: <a href=\"http://64.50.182.163/~hepshego/tecnico/login\">Módulo Técnico</a></html>";
    
    	//FINAL DO TEXTO DA SOLICITACAO
    
    	//ENVIO DA SOLICITACAO
    	$enviarEmail = $this->EnviarEmail()->Envio($destinatario,"Abertura de Nova Solicitação - Código {$codigoSolicitacao}",$html);
    
    	return $this->getResponse()->setContent($enviarEmail);
    
    }
    
    
    
}

?>