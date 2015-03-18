<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CadlogTable
{
    protected $tableGateway;
    
    function __construct(TableGateway $tableGateway){
    	$this->tableGateway = $tableGateway;        
    }
   
    public function fetchAll($filter=null,$start=0,$limit=25,$order='cadlog.date DESC'){

        try{
        	$resultSet = $this->tableGateway->select(function(Select $select)use($filter,$order,$start,$limit){
        		$select->limit($limit)->offset($start)->order($order);
        		 
        		if($filter!=null){
        			$select->where($filter);
        		}
        	
        
        	});
        	return $resultSet;
        }
        catch(\Exception $e){
        	return $e->getMessage();
        }
        
        
    }
    
}

?>