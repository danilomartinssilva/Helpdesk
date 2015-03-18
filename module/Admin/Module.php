<?php
namespace Admin;

use Zend\Mvc\ModuleRouteListener;

use Zend\Mvc\MvcEvent;
//use Admin\Model\CaddepTable;
use Zend\Db\ResultSet\ResultSet;
//use Admin\Model\Caddep;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\CaddepTable;
use Admin\Model\CadcliTable;
use Admin\Model\Caddep;
use Admin\Model\Cadcli;
use Admin\Model\CadperfilTable;
use Admin\Model\Cadperfil;
use Admin\Model\Cadser;
use Admin\Model\Cadpri;
use Admin\Model\Cadsol;
use Admin\Model\Cadaco;
use Admin\Model\Cadsta;
use Admin\Model\Espectec;
use Admin\Model\Caddir;
use Zend\Authentication\AuthenticationService;
use Admin\Model\Cadlog;
use Admin\Model\Cadbase;

//use Admin\Model\CaddepTable;
class Module
{
    public function onBootstrap(MvcEvent $e)
    {
     
    }
    
    public function getConfig()
    {
    	return include __DIR__ . '/config/module.config.php';
    	
    }
    
    public function getAutoloaderConfig()
    {
    	return array(
    			'Zend\Loader\StandardAutoloader' => array(
    					'namespaces' => array(
    							__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
    					      
    					),
    			),
    	  
    	);
    }
  
 
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Admin\Model\CaddepTable' =>  function($sm) {
    						$tableGateway = $sm->get('CaddepTableGateway');
    						$table = new CaddepTable($tableGateway);
    						return $table;
    					},
    					'CaddepTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Caddep());
    						return new TableGateway('caddep', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Admin\Model\CadcliTable'=>function($sm){
    						$tableGateway = $sm->get('CadcliTableGateway');
    						$table = new CadcliTable($tableGateway);
    						return $table;
    					},
    					'CadcliTableGateway'=>function($sm){
    					    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    					    $resultSetPrototype = new ResultSet();
    					    $resultSetPrototype->setArrayObjectPrototype(new Cadcli());
    					    return new TableGateway('cadcli', $dbAdapter,null,$resultSetPrototype);	
    					},
    					'Admin\Model\CadperfilTable'=>function($sm){
    						$tableGateway = $sm->get('CadperfilTableGateway');
    						$table = new \Admin\Model\CadperfilTable($tableGateway);
    						return $table;
    					},
    					'CadperfilTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadperfil());
    						return new TableGateway('cadperfil', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadserTable'=>function($sm){
    						$tableGateway = $sm->get('CadserTableGateway');
    						$table = new \Admin\Model\CadserTable($tableGateway);
    						return $table;
    					},
    					'CadserTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadser());
    						return new TableGateway('cadser', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadpriTable'=>function($sm){
    						$tableGateway = $sm->get('CadpriTableGateway');
    						$table = new \Admin\Model\CadpriTable($tableGateway);
    						return $table;
    					},
    					'CadpriTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadpri());
    						return new TableGateway('cadpri', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadsolTable'=>function($sm){
    						$tableGateway = $sm->get('CadsolTaleGateway');
    						$table = new \Admin\Model\CadsolTable($tableGateway);
    						return $table;
    					},
    					'CadsolTaleGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadsol());
    						return new TableGateway('cadsol', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadacoTable'=>function($sm){
    						$tableGateway = $sm->get('CadacoTableGateway');
    						$table = new \Admin\Model\CadacoTable($tableGateway);
    						return $table;
    					},
    					'CadacoTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadaco());
    						return new TableGateway('cadaco', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadstaTable'=>function($sm){
    						$tableGateway = $sm->get('CadstaTableGateway');
    						$table = new \Admin\Model\CadstaTable($tableGateway);
    						return $table;
    					},
    					'CadstaTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadsta());
    						return new TableGateway('cadsta', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CaddirTable'=>function($sm){
    						$tableGateway = $sm->get('CaddirTableGateway');
    						$table = new \Admin\Model\CaddirTable($tableGateway);
    						return $table;
    					},
    					'CaddirTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Caddir());
    						return new TableGateway('caddir', $dbAdapter,null,$resultSetPrototype);
    					},
    					'Admin\Model\CadlogTable'=>function($sm){
    						$tableGateway = $sm->get('CadlogTableGateway');
    						$table = new \Admin\Model\CadlogTable($tableGateway);
    						return $table;
    					},
    					'CadlogTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadlog());
    						return new TableGateway('cadlog', $dbAdapter,null,$resultSetPrototype);
    					},
    					
    					'Admin\Model\CadbaseTable'=>function($sm){
    						$tableGateway = $sm->get('CadbaseTableGateway');
    						$table = new \Admin\Model\CadbaseTable($tableGateway);
    						return $table;
    					},
    					'CadbaseTableGateway'=>function($sm){
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadbase());
    						return new TableGateway('cadbase', $dbAdapter,null,$resultSetPrototype);
    					},
    					
    					
    					
    					
    					
    					
    			),
    	);
    }
}

?>