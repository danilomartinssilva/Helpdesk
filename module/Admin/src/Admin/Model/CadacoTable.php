<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Adapter\Adapter as Adaptador;
use Zend\Log\Writer\Db as Gravar;
use Zend\Log\Logger as MyLogger;
use Zend\Log\Writer\Mock as Mock;
use Admin\Controller\Plugin\Validarcpf;
use Admin\Controller\Plugin\GerarLog;
use Zend\Db\Sql\Sql;


class CadacoTable
{

    protected $tableGateway;

    function __construct (TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll ($filter = null, $start = 0, $limit = 25, $order = 'id_cadaco DESC')
    {
        try {
            $resultSet = $this->tableGateway->select(function  (Select $select) use( $filter, $order, $start, $limit)
            {
                $select->limit($limit)
                    ->offset($start)
                    ->order($order);
                
                if ($filter != null) {
                    $select->where($filter);
                }
                $select->join(array(
                    'cadsol' => 'cadsol'
                ), 'cadsol.id_cadsol=cadaco.cd_cadsol', array(
                    'desc_cadsol' => 'desc_cadsol',
                    'id_cadsol' => 'id_cadsol'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'cadcli' => 'cadcli'
                ), 'cadcli.id_cadcli=cadsol.cd_cadcli', array(
                    'desc_cadcli' => 'desc_cadcli',
                    'id_cadcli' => 'id_cadcli'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'atendente' => 'cadcli'
                ), 'atendente.id_cadcli=cadaco.cd_cadcli', array(
                    'descricao_atendente' => 'desc_cadcli',
                    'id_atendente' => 'id_cadcli'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'caddep' => 'caddep'
                ), 'caddep.id_caddep=cadcli.cd_caddep', array(
                    'desc_caddep' => 'desc_caddep',
                    'id_caddep' => 'id_caddep'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'cadsta' => 'cadsta'
                ), 'cadsta.id_cadsta=cadaco.cd_cadsta', array(
                    'desc_cadsta' => 'desc_cadsta',
                    'id_cadsta' => 'id_cadsta'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'cadser' => 'cadser'
                ), 'cadser.id_cadser=cadsol.cd_cadser', array(
                    'desc_cadser' => 'desc_cadser',
                    'id_cadser' => 'id_cadser'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'cadpri' => 'cadpri'
                ), 'cadpri.id_cadpri = cadser.cd_cadpri', array(
                    'desc_cadpri' => 'desc_cadpri',
                    'id_cadpri' => 'id_cadpri'
                ), Select::JOIN_INNER);
                $select->join(array(
                    'cadperfil' => 'cadperfil'
                ), 'cadperfil.id_cadper = cadcli.cd_cadper', array(
                    'desc_cadper' => 'desc_cadper',
                    'id_cadper' => 'id_cadper'
                ), Select::JOIN_INNER);
                
              
            });
               
           
            
            return $resultSet;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveAcompanhamento (Cadaco $cadaco)
    {
        try {
            $data = array(
                'desc_cadaco' => $cadaco->desc_cadaco,
                'cd_cadsol' => $cadaco->cd_cadsol,
                'cd_cadcli' => $cadaco->cd_cadcli,
                'cd_cadsta' => $cadaco->cd_cadsta,
                'atualizacao_cadaco' => $cadaco->atualizacao_cadaco
            );
            $insert = $this->tableGateway->insert($data);
            
            return $this->tableGateway->lastInsertValue;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function count ($id = null, $campo = null, $valor = null)
    {
        try {
            $table = $this->tableGateway->getTable();
            $resultSet = $this->tableGateway->select(function  (Select $select) use( $id, $valor, $campo, $table)
            {
                if ($id != null && $campo == null && $valor == null) {
                    $select->where(array(
                        "{$table}.id_cadaco" => $id
                    ));
                }
                if ($id != null && $campo != null && $valor != null) {
                    $select->where(array(
                        "{$table}.id_cadaco" => $id
                    ));
                    $select->where(array(
                        "{$table}.{$campo}" => $valor
                    ));
                }
            })
                ->count();
        
           return $resultSet;
           
           
       }catch(\Exception $e){
       	    return $e->getMessage();
       }
        
    }
    public function deleteAcompanhamento($where){
    	try{
    	    
    	    $delete = $this->tableGateway->delete($where);
    	    if($delete){
    	    	return true;
    	    }
    	    else{
    	    	return false;
    	    }
    	    
    	}
    	catch( \Exception $e){
    		return $e->getMessage();
    	}
        
        
    }
    
    
}

?>