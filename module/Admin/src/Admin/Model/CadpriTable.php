<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CadpriTable
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway){
    	$this->tableGateway = $tableGateway;
    }
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadpri DESC'){
        $limit = (int)$limit;
        $start = (int)$start;
    	try{
    	$resultSet = $this->tableGateway->select();
    	
    	return $resultSet;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
    public function count($where=null){
    	
        try{
        	$resultSet =$this->tableGateway->select(function(Select $select)use($where){
        		$select->where($where);
        	})->count();
        	return $resultSet;
        }
        catch(\Exception $e){
        	return $e->getMessage();
        }
        
    }
    
    /*
     *  public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadcli DESC')
    {
        $limit = (int)$limit;
        $start = (int)$start;
        $resultSet = $this->tableGateway->select(function(Select $select) use ($order,$start,$limit,$filter){
        //	$select->columns(array('desc_caddep','id_caddep','responsavel_caddep','telefone_caddep','parent_caddep','status_caddep'));
        	$select->join(array('caddep'=>'caddep'), 'caddep.id_caddep = cadcli.cd_caddep',array('desc_caddep'=>'desc_caddep','id_caddep'=>'id_caddep'),Select::JOIN_INNER);        	
        	$select->join(array('cadperfil'=>'cadperfil'), 'cadperfil.id_cadper = cadcli.cd_cadper',array('desc_cadper'=>'desc_cadper','id_cadper'=>'id_cadper'),Select::JOIN_INNER);
        	$select->order($order);
        	$select->offset($start)->limit($limit);
        	if($filter!=null){
        		$select->where($filter);
        	}
        	//print_r($select->getSqlString());
        
        });        
        	return $resultSet;
    
    }
     */
    
}

?>