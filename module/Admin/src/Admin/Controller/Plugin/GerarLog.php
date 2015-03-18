<?php
namespace Admin\Controller\Plugin;
use Zend\Di;

use Zend\Db\Adapter\Adapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class GerarLog extends AbstractPlugin
{
    
    public function log($adapter,$namesession,$action,$target){
        $date = date('Y-m-d H:i:s');
        $auth = new AuthenticationService();
        if($namesession=="user"){
        	$auth->setStorage(new Session('user'));
        }
        if($namesession=="admin"){
        	$auth->setStorage(new Session('admin'));
        }
        
        if($namesession=='tecnico'){        	
            $auth->setStorage(new Session('tecnico'));            
        }
        
        $email = $auth->getStorage()->read()->email_cadcli;
        $nome = $auth->getStorage()->read()->desc_cadcli;
        
        $stmt = $adapter->query("INSERT INTO `cadlog` (`usuario`, `email`,`date`,`action`,`target`) VALUES ('{$nome}', '{$email}','{$date}','{$action}','{$target}')")->execute();
        //$stmt->execute();
     // $adaptador = new Adapter($adapter);
     // $stament = $adaptador->query("INSERT INTO `cadlog` (`date`, `type`) VALUES ('2014-12-25 00:28:10', '6')");
      //print_r($stament->execute());
      
      
        
        
        
    }
}

?>