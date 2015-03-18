<?php


namespace Admin\Controller\Plugin;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\ServiceManager\ServiceManager;
use Zend\Validator\Db\NoRecordExists;
use Zend\Db\Adapter\Adapter;




class RemoteValidate extends AbstractPlugin
{
    public function validar($serviceLocator,$tableName,$field,$id=null,$value,$adapter){
        
    	
        $field = (isset($field)) ? $field : null;
       // $adapter = new Adapter();
        $id = (isset($id)) ? (int) $id:null;
        $value = (isset($value)) ? $value : null;
        $tableName = (isset($tableName)) ? $tableName : null;
        //print_r($adapter);
        $validator = new NoRecordExists(
                array('table' =>$tableName,'adapter'=>$adapter,'field'=>$field)
            );
        //return $adapter;
        if($id==null){
        	if($validator->isValid($value)){
        	    $retorno['success'] = true;
        		
        	}else{
        		$retorno['success'] = false;
        	}
        }else{
            $count = (int) $serviceLocator->count($id,$field,$value);
            if($count>0){
            	$retorno['success'] = true;
            }
            else{
            	if($validator->isValid($value)){
            		$retorno['success'] = true;
            	}
            	else{
            		$retorno['success'] = false;
            	}
            }	
        }  
        return $retorno; 
        
    }
    
    /* $request = $this->request->getPost();
        $field = trim($field);
        $value = trim($value);
        $id = (isset($id)) ? (int) $id : null;
        $validator = new NoRecordExists(
        		array('table'=>'cadcli','adapter'=>$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),'field'=>$field)
        );
        
        if($id==null){
        	 
        	if($validator->isValid($value)){
        		$retorno['success'] = true;
        	}
        	else{
        		$retorno['success'] = false;
        	}
        
        }
        else{
        	$count =(int) $this->getCadcliTable()->countCliente($id,$field,$value);
        	if($count>0){
        		$retorno['success'] = true;
        
        	}
        	else{
        		if($validator->isValid($value)){
        			$retorno['success'] = true;
        		}
        		else{
        			$retorno['success'] = false;
        		}
        	}*/
}

?>