<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/',
            				'defaults' => array(
            						'controller' => 'User\Controller\Index',
            						'action'     => 'index',
            				),
            		),
            ),
            'user' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/user',
                    'defaults' => array(
                        'controller' => 'User\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            
            'userlogin' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/user/index/login',
            				'defaults' => array(
            						'controller' => 'User\Controller\Index',
            						'action'     => 'login',
            				),
            		),
            ),
            'userstatus' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/user/status',
            				'defaults' => array(
            						'controller' => 'User\Controller\Status',
            						'action'     => 'list',
            				),
            		),
            ),
            'useracompanhamento' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/user/acompanhamento',
            				'defaults' => array(
            						'controller' => 'User\Controller\Acompanhamento',
            						'action'     => 'list',
            				),
            		),
            ),
            'userservico' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route'    => '/user/servico',
            				'defaults' => array(
            						'controller' => 'User\Controller\Servico',
            						'action'     => 'list',
            				),
            		),
            ),
            'user' => array(
            		'type'    => 'Literal',
            		'options' => array(
            				'route'    => '/user',
            				'defaults' => array(
            						'__NAMESPACE__' => 'User\Controller',
            						'controller'    => 'Index',
            						'action'        => 'index',
            				),
            		),
            		'may_terminate' => true,
            		'child_routes' => array(
            				'default' => array(
            						'type'    => 'Segment',
            						'options' => array(
            								'route'    => '/[:controller[/:action]]',
            								'constraints' => array(
            										'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
            										'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
            								),
            								'defaults' => array(
            								),
            						),
            				),
            		),
            ),
            
        
            /*
            'admin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
       */
    
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
    'controllers' => array(
        'invokables' => array(        
        'User\Controller\Index' => 'User\Controller\IndexController',
        'User\Controller\Solicitacao' => 'User\Controller\SolicitacaoController'   ,
        'User\Controller\Status' => 'User\Controller\StatusController',
        'User\Controller\Servico' => 'User\Controller\ServicoController',
        'User\Controller\Acompanhamento' => 'User\Controller\AcompanhamentoController',
        'User\Controller\Cliente' =>'User\Controller\ClienteController'            
                
                
        ),
    ),
    'view_manager' => array(
     //   'display_not_found_reason' => true,
     //   'display_exceptions'       => true,
     //   'doctype'                  => 'HTML5',
     //   'not_found_template'       => 'error/404',
     //   'exception_template'       => 'error/index',
    /*    'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),*/
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
