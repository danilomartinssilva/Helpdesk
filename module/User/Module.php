<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use User\Model\CadsolTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Admin\Model\Cadsol;
use Admin\Model\CadstaTable;
use Admin\Model\Cadsta;
use Admin\Model\CadserTable;
use Admin\Model\Cadser;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $e->getApplication()->getServiceManager()->get('translator');
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    			    /*
    					'User\Model\CadsolTable' =>  function($sm) {
    						$tableGateway = $sm->get('CadsolTableGateway');
    						$table = new CadsolTable($tableGateway);
    						return $table;
    					},
    					'CadsolTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadsol());
    						return new TableGateway('cadsol', $dbAdapter, null, $resultSetPrototype);
    					},
    					'User\Model\CadstaTable' =>  function($sm) {
    						$tableGateway = $sm->get('CadstaTableGateway');
    						$table = new CadstaTable($tableGateway);
    						return $table;
    					},
    					'CadstaTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadsta());
    						return new TableGateway('cadsta', $dbAdapter, null, $resultSetPrototype);
    					},
    					'User\Model\CadserTable' =>  function($sm) {
    						$tableGateway = $sm->get('CadserTableGateway');
    						$table = new CadserTable($tableGateway);
    						return $table;
    					},
    					'CadserTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cadser());
    						return new TableGateway('cadser', $dbAdapter, null, $resultSetPrototype);
    					},
    				*/
    			),
    	);
    }
}
