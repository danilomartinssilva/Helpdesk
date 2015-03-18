<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Admin\Controller\Plugin\GerarLog;
class CadserTable 
{
    protected $tableGateway;
    
    
    function __construct(TableGateway $tableGateway){
    	$this->tableGateway=$tableGateway;
    	
    }
    
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadser DESC'){
    	$limit = (int)$limit;
    	$start = (int)$start;
    	$resultSet = $this->tableGateway->select(function (Select $select)use($filter,$start,$limit,$order){
		$select->limit($limit)->order($order)->offset($start);
		//$select->join(array('caddep'=>'caddep'), 'caddep.id_caddep = cadcli.cd_caddep',array('desc_caddep'=>'desc_caddep','id_caddep'=>'id_caddep'),Select::JOIN_INNER);
		$select->join(array('prioridades'=>'cadpri'),'prioridades.id_cadpri=cadser.cd_cadpri',array('desc_cadpri'=>'desc_cadpri','tempo_cadpri'=>'tempo_cadpri','componente_cadpri'=>'componente_cadpri','id_cadpri'=>'id_cadpri'),Select::JOIN_INNER);
		$select->join(array('categorias'=>'cadser'),'categorias.id_cadser=cadser.parent_cadser',array('descricao'=>'desc_cadser','id'=>'id_cadser'),Select::JOIN_INNER);
		if($filter!=null){
			$select->where($filter);
		}   
    	    
    	});
    	 
    	return $resultSet;
    }
    public function saveServico(Cadser $cadser){
    	try{
    	    
    		$data = array('desc_cadser'=>$cadser->desc_cadser,'obs_cadser'=>$cadser->obs_cadser,
    		    'status_cadser'=>$cadser->status_cadser,
    		    'cd_cadpri'=>$cadser->cd_cadpri,
    		    'cd_caddir'=>$cadser->cd_caddir,
    		    'tempo_cadser'=>$cadser->tempo_cadser,
    		    'parent_cadser'=>$cadser->parent_cadser);
    		$insert = $this->tableGateway->insert($data);
    		
    		if($insert){
    		    
    			return $this->tableGateway->lastInsertValue;
    		}
    		
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    	
    }
    public function updateServico(Cadser $cadser){
        try{
        	$data = array('desc_cadser'=>$cadser->desc_cadser,'obs_cadser'=>$cadser->obs_cadser,
    		    'status_cadser'=>$cadser->status_cadser,
    		    'cd_cadpri'=>$cadser->cd_cadpri,
        	    'cd_caddir'=>$cadser->cd_caddir,
        	    'tempo_cadser'=>$cadser->tempo_cadser,
    		    'parent_cadser'=>$cadser->parent_cadser);
        	
        	$update = $this->tableGateway->update($data,array('id_cadser'=>$cadser->id_cadser));
        	//print_r($update);
        	if($update){
        	 
                return true;
        	}
        
        }catch(\Exception $e){
            
        	return $e->getMessage();
        }
        
    }
    public function deleteServico($id){
        try{
        	$id = (int) $id;
        	
        return($this->tableGateway->delete(array('id_cadser'=>$id)));
        }catch(\Exception $e){
        	return $e->getMessage();
        }
    }
    public function count($where=null){
    	try{
    	    
    	    $resultSet = $this->tableGateway->select(function(Select $select)use($where){
    	    	if($where!=null){
    	    		$select->where($where);
    	    	}
    	    })->count();
    	    return $resultSet;
    		
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    } 
    
    
}

?>