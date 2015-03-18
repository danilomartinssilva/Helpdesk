<?php
namespace Admin\Model;

use Admin\Controller\Plugin\GerarLog;
use Zend\Db\TableGateway\TableGateway;

use Zend\Db\Sql\Select;

class CadbaseTable
{

    protected $tableGateway;

    function __construct (TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function saveBase (Cadbase $cadbase)
    {
        try {
            $data = array(
                'texto_cadbase'=>$cadbase->texto_cadbase,
                'titulo_cadbase'=>$cadbase->titulo_cadbase,
                'autor_cadbase'=>$cadbase->autor_cadbase,
                'atualizacao_cadbase'=>$cadbase->atualizacao_cadbase,
                //'id_cadbase'=>$cadbase->id_cabase
                 
            );
            $insert = $this->tableGateway->insert($data);
            if ($insert) {
                return $this->tableGateway->lastInsertValue;
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function fetchAll($filter=null,$start=0,$limit=20,$order='id_cadbase DESC'){
    	try{
    		$resultSet = $this->tableGateway->select(function (Select $select) use ($filter,$start,$limit,$order){
    			
    			//$select->join(array('cadser'=>'cadser'), 'cadser.id_cadser=caddir.cd_cadser',array('desc_cadser'=>'desc_cadser','id_cadser'=>'id_cadser'),Select::JOIN_INNER);
    			
    		    if(is_array($filter)){
    				for($i=0;$i<count($filter);$i++){
    					$select->where($filter[$i]);
    					
    				}
    			}
    		
    			$select->order($order)->offset($start)->limit($limit);
    				
    		});
    		return $resultSet;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
   public function deleteBase($idBase){
   	
       try{
           
       	return $this->tableGateway->delete(array('cadbase.id_cadbase'=>$idBase));
       }
       catch(\Exception $e){
       	return $e->getMessage();
       }
       
   }
}


?>