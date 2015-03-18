<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
class CadstaTable
{
    protected $tableGateway;
    public function __construct(TableGateway $tableGateway){
    	$this->tableGateway = $tableGateway;
    }
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadsta DESC'){
    	try{
    	    $limit = (int) $limit;
    	    $start = (int) $start;
    	    $resultSet = $this->tableGateway->select(function(Select $select)use($filter,$start,$limit,$order){
    	    	$select->limit($limit);
    	    	$select->offset($start);
    	    	$select->order($order);
    	    	if($filter!=null){
    	    		$select->where($filter);
    	    	}
    	    });
    	    return $resultSet;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
}

?>