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
            'tecnico' => array(
            		'type'    => 'Literal',
            		'options' => array(
            				'route'    => '/tecnico',
            				'defaults' => array(
            						'__NAMESPACE__' => 'Tecnico\Controller',
            						'controller'    => 'Index',
            						'action'        => 'login',
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
            'logintecnico' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/tecnico/login',
                    'defaults' => array(
                        'controller' => 'Tecnico\Controller\Index',
                        'action' => 'login'
                    )
                )
            ),
            'solicitacaotecnico' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/tecnico/solicitacao',
                    'defaults' => array(
                        'controller' => 'Tecnico\Controller\Solicitacao',
                        'action' => 'list'
                    )
                )
            ),
            'clientestecnico' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/tecnico/cliente',
                    'defaults' => array(
                        'controller' => 'Tecnico\Controller\Cliente',
                        'action' => 'list'
                    )
                )
            ),
            'statustecnico' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route' => '/tecnico/status',
            				'defaults' => array(
            						'controller' => 'Tecnico\Controller\Status',
            						'action' => 'list'
            				)
            		)
            ),
            'servicotecnico' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route' => '/tecnico/servico',
            				'defaults' => array(
            						'controller' => 'Tecnico\Controller\Servico',
            						'action' => 'list'
            				)
            		)
            ),
            'acompanhamentotecnico' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route' => '/tecnico/acompanhamento',
            				'defaults' => array(
            						'controller' => 'Tecnico\Controller\Acompanhamento',
            						'action' => 'list'
            				)
            		)
            ),
            'basedeconhecimentotecnico' => array(
            		'type' => 'Zend\Mvc\Router\Http\Literal',
            		'options' => array(
            				'route' => '/tecnico/basedeconhecimento',
            				'defaults' => array(
            						'controller' => 'Tecnico\Controller\Basedeconhecimento',
            						'action' => 'list'
            				)
            		)
            ),
        )
        
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\Adapter'
        )
    ),
    /*
    'controller_plugins' => array(
    		'invokables' => array(
    				'Validarcpf' => 'Admin\Controller\Plugin\Validarcpf',
    				'RemoteValidate' => 'Admin\Controller\Plugin\RemoteValidate',
    				
    				
    		),
    ),
    */		
  /*
     * 'translator' => array( 'locale' => 'en_US', 'translation_file_patterns' => array( array( 'type' => 'gettext', 'base_dir' => __DIR__ . '/../language', 'pattern' => '%s.mo', ), ), ),
     */
    'controllers' => array(
        'invokables' => array(
            'Tecnico\Controller\Index' => 'Tecnico\Controller\IndexController',
            'Tecnico\Controller\Solicitacao' => 'Tecnico\Controller\SolicitacaoController',
            'Tecnico\Controller\Cliente' => 'Tecnico\Controller\ClienteController',
            'Tecnico\Controller\Status' => 'Tecnico\Controller\StatusController',
            'Tecnico\Controller\Servico' => 'Tecnico\Controller\ServicoController',
            'Tecnico\Controller\Acompanhamento' => 'Tecnico\Controller\AcompanhamentoController',
            'Tecnico\Controller\Basedeconhecimento' => 'Tecnico\Controller\BasedeconhecimentoController',
            
        /*
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Departamento' => 'Admin\Controller\DepartamentoController',
            'Admin\Controller\Cliente' => 'Admin\Controller\ClienteController',
            'Admin\Controller\Perfil' => 'Admin\Controller\PerfilController',
            'Admin\Controller\Servicos' => 'Admin\Controller\ServicosController',
            'Admin\Controller\Prioridade' => 'Admin\Controller\PrioridadeController',
            'Admin\Controller\Solicitacao' => 'Admin\Controller\SolicitacaoController',
            'Admin\Controller\Acompanhamento' => 'Admin\Controller\AcompanhamentoController',
            'Admin\Controller\Status' => 'Admin\Controller\StatusController',
         */                
                
        )
    ),
    'view_manager' => array(
        // 'display_not_found_reason' => true,
        // 'display_exceptions' => true,
        // 'doctype' => 'HTML5',
        // 'not_found_template' => 'error/404',
        // 'exception_template' => 'error/index',
        /*
         * 'template_map' => array( 'layout/layout' => __DIR__ . '/../view/layout/layout.phtml', 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml', 'error/404' => __DIR__ . '/../view/error/404.phtml', 'error/index' => __DIR__ . '/../view/error/index.phtml', ),
         */
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
