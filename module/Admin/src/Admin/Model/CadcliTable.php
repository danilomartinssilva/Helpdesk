<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Admin\Controller\Plugin\GerarLog;
//use Zend\Db\Sql\Expression;
class CadcliTable
{
    protected  $tableGateway;
    
    public function __construct(TableGateway $tableGateway){
    	$this->tableGateway = $tableGateway;
    }
    public function fetchAll($filter=null,$start=0,$limit=25,$order='id_cadcli DESC')
    {
        $limit = (int)$limit;
        $start = (int)$start;
        $resultSet = $this->tableGateway->select(function(Select $select) use ($order,$start,$limit,$filter){
        //	$select->columns(array('desc_caddep','id_caddep','responsavel_caddep','telefone_caddep','parent_caddep','status_caddep'));
        	$select->join(array('caddep'=>'caddep'), 'caddep.id_caddep = cadcli.cd_caddep',array('desc_caddep'=>'desc_caddep','id_caddep'=>'id_caddep'),Select::JOIN_INNER);        	
        	$select->join(array('cadperfil'=>'cadperfil'), 'cadperfil.id_cadper = cadcli.cd_cadper',array('desc_cadper'=>'desc_cadper','id_cadper'=>'id_cadper'),Select::JOIN_INNER);
        	$select->join(array('caddir'=>'caddir'), 'caddir.id_caddir = cadcli.cd_caddir',array('descricao_caddir'=>'descricao_caddir','id_caddir'=>'id_caddir'),Select::JOIN_INNER);
        	$select->order($order);
        	$select->offset($start)->limit($limit);
        	if($filter!=null){
        		$select->where($filter);
        	}
        	
        
        });    

       
        	return $resultSet;
    
    }
    public function getCliente($where){
        $id = (int) $id;
        $rowset = $this->tableGateway->select(function (Select $select) use($where){
        	$select->where($where);            
        });
        $row = $rowset->current();
        if(!$row){
        	throw new \Exception("Nao foi encontrado registros");
        }
        return $row;
    }
    public function deletarCliente($id)
    {
        $id = (int) $id;
    	try{
    		
    	  return  $this->tableGateway->delete(array('id_cadcli' => $id));
    		
    		
    		
    	}catch(\Exception $e){
    		return $e->getCode();
    	}
    	 
    }
    
    public function saveCliente(Cadcli $cadcli)
    {
    	try{
    		$data = array(
    		        'cd_caddir'=>$cadcli->cd_caddir,
    				'desc_cadcli'=>$cadcli->desc_cadcli,
    		        'cpf_cadcli'=>$cadcli->cpf_cadcli,
    		        'email_cadcli'=>$cadcli->email_cadcli,
    		        'telefone_cadcli'=>$cadcli->telefone_cadcli,
    		        'ramal_cadcli'=>$cadcli->ramal_cadcli,
    		        'celular_cadcli'=>$cadcli->celular_cadcli,
    		        'funcao_cadcli'=>$cadcli->funcao_cadcli,
    		        'status_cadcli'=>$cadcli->status_cadcli,
    		        'cd_caddep'=>$cadcli->cd_caddep,
    		        'cd_cadper'=>$cadcli->cd_cadper,
    		        'senha_cadcli' =>$cadcli->senha_cadcli
    		);
    		$this->tableGateway->insert($data);
    	
    	//	$data['id_caddep'] = $this->tableGateway->lastInsertValue;
    		return $this->tableGateway->lastInsertValue;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    
    }
    public function updateCliente(Cadcli $cadcli){
    try{
    		$data = array(
    		        'cd_caddir'=>$cadcli->cd_caddir,
    				'desc_cadcli'=>$cadcli->desc_cadcli,
    		        'cpf_cadcli'=>$cadcli->cpf_cadcli,
    		        'email_cadcli'=>$cadcli->email_cadcli,
    		        'telefone_cadcli'=>$cadcli->telefone_cadcli,
    		        'ramal_cadcli'=>$cadcli->ramal_cadcli,
    		        'celular_cadcli'=>$cadcli->celular_cadcli,
    		        'funcao_cadcli'=>$cadcli->funcao_cadcli,
    		        'status_cadcli'=>$cadcli->status_cadcli,
    		        'cd_caddep'=>$cadcli->cd_caddep,
    		        'cd_cadper'=>$cadcli->cd_cadper,
    		        'id_cadcli' =>$cadcli->id_cadcli,
    		        'senha_cadcli' =>$cadcli->senha_cadcli
    		);
    		$this->tableGateway->update($data,array('id_cadcli'=>(int)$data['id_cadcli']));
    	
    		
    		//$data['id_cadcli'] = $this->tableGateway->lastInsertValue;
    		return $data;
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
    public function count($id=null,$campo=null,$valor=null){
        if($id==null || $campo==null || $valor==null ){
            $resultSet = $this->tableGateway->select()->count();
        }
        else{
           $where = "cadcli.id_cadcli = {$id} and cadcli.{$campo}='{$valor}'";
           $resultSet = $this->tableGateway->select(function(Select $select)use($where){ 
           $select->where($where);  
           })->count();           
        }
    	
    	return $resultSet;
    }
    public function deleteCliente($id){
    	try{
    		return $this->tableGateway->delete(array('cadcli.id_cadcli'=>$id));
    		
    	
    		
    	}catch(\Exception $e){
    		return $e->getMessage();
    	}
    }
    /***
     * A funчуo deste mщtodo щ  migrar os usuсrios para o grupo Nenhum
     */

        

    
    
}

?>