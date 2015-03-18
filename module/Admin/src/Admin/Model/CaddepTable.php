<?php
namespace Admin\Model;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Admin\Controller\Plugin\GerarLog;


class CaddepTable
{
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway){
    	$this->tableGateway = $tableGateway;        
    }

    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_caddep DESC')
    {
    	    $limit = (int)$limit;
    	    $start = (int)$start;   
            $resultSet = $this->tableGateway->select(function(Select $select) use ($order,$start,$limit,$order,$filter){                  
    		$select->columns(array('desc_caddep','id_caddep','responsavel_caddep','telefone_caddep','parent_caddep','status_caddep'));
    	    $select->join(array('departamento_responsavel'=>'caddep'), 'departamento_responsavel.id_caddep = caddep.parent_caddep',array('descricao_responsavel'=>'desc_caddep','id_responsavel'=>'id_caddep'),Select::JOIN_INNER);
    	    $select->offset($start)->limit($limit); 
    	    $select->order($order);    	     
    	    
    	    if($filter!=null){
    	    	$select->where($filter);
    	    }
    	   
    	});
               
        return $resultSet;
        
    }    
    
    public function getDepartamento($id){
    	$id = (int) $id;
    	$rowset = $this->tableGateway->select(array('id'=>$id));
    	$row = $rowset->current();
    	if(!$row){
    		throw new \Exception("Nao foi encontrado registros");
    	}
    	return $row;
    }
    public function deleteDepartamento($id)
    {
      try{
       return $this->tableGateway->delete(array('id_caddep' => (int) $id));          
      }catch(\Exception $e){
          return $e->getCode();     	
      }
   
    }
    public function saveDepartamento(Caddep $caddep)
    {
        try{
        $data = array(
        		'desc_caddep' => $caddep->desc_caddep,
        		'parent_caddep'  => $caddep->parent_caddep,
        		'status_caddep'  => $caddep->status_caddep,
        		'responsavel_caddep'  => $caddep->responsavel_caddep,
        		'telefone_caddep'  => $caddep->telefone_caddep,
        );
        $this->tableGateway->insert($data);
        
        
        return $this->tableGateway->lastInsertValue;
        
        
        }catch(\Exception $e){
        	return $e->getMessage();
        }

    }
    public function updateDepartamento(Caddep $caddep){
    	try{
    	    $data = array('desc_caddep'=>$caddep->desc_caddep,
    	                  'parent_caddep'=>$caddep->parent_caddep,
    	                   'status_caddep'=>$caddep->status_caddep,
    	                   'responsavel_caddep'=>$caddep->responsavel_caddep,
    	                   'telefone_caddep' =>$caddep->telefone_caddep,
    	                    'id_caddep'=>$caddep->id_caddep,
    	                );
    	    $this->tableGateway->update($data,array('id_caddep'=>$caddep->id_caddep));
    	    return $data;
    	}catch( \Exception $e){
    		return $e->getMessage();
    	}
    }
    public function count(){
    	
        $resultSet = $this->tableGateway->select()->count();
    	return $resultSet;
    }
}

?>