<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Admin\Controller\Plugin\GerarLog;
class CaddirTable
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway){
        $this->tableGateway = $tableGateway;        
    }
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_caddir DESC'){
    	try{
        $resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$start,$limit,$order){
    		$select->order($order)->offset($start)->limit($limit);
    		
    		
    		//$select->join(array('cadser'=>'cadser'), 'cadser.id_cadser=caddir.cd_cadser',array('desc_cadser'=>'desc_cadser','id_cadser'=>'id_cadser'),Select::JOIN_INNER);
    		if(is_array($filter)){
    			for($i=0;$i<count($filter);$i++){
    				$select->where($filter[$i]);
    			}
    		}
    	    
    	});
         return $resultSet;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
    public function saveDirecionamento(Caddir $caddir){
        try{
    	$data = array('descricao_caddir'=>$caddir->desc_caddir);    	
    	$insert =  $this->tableGateway->insert($data);
    	if($insert){
    	  
    	return $this->tableGateway->lastInsertValue;
    	}
    	
        }catch(\Exception $e){
        	return $e->getMessage();
        }
        
    }
    public function deleteDirecionamento($idDirecionamento){
    	try{
    	  return $this->tableGateway->delete("caddir.id_caddir = {$idDirecionamento}");
    	  
    	}
    	catch( \Exception $e){
    		return $e->getCode();
    	}
    }
    
    public function updateDirecionamento(Caddir $caddir){
    	try{
    		$data = array(
    				'id_caddir'=>$caddir->id_caddir,    				
    				'descricao_caddir'=>$caddir->descricao_caddir,
    				
    		);
    		$this->tableGateway->update($data,array('id_caddir'=>(int)$data['id_caddir']));
    	
    		//$data['id_cadcli'] = $this->tableGateway->lastInsertValue;
    		return $data;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
 
}

?>