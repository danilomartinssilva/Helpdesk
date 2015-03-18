<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CadperfilTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway){
            $this->tableGateway = $tableGateway;
        
    }
    
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadper DESC'){
        
    	$resultSet = $this->tableGateway->select(function(Select $select) use ($filter,$start,$limit,$order){
    	    if($filter!=null){
    	    	$select->where($filter);
    	    }
    	    $select->order($order);
    	    $select->offset($start)->limit($limit);    	    
    	});
    	return $resultSet;
    	
        
    }
}

?>