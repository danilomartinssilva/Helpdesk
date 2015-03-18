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
            'admin' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'index'
                    )
                )
            ),
            'login' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action' => 'login'
                    )
                )
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            
            'admin' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
                            ),
                            'defaults' => array()
                        )
                    )
                )
            ),
            'departamentoListar' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/departamento',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Departamento',
                        'action' => 'list'
                    )
                )
            ),
            'cliente' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/cliente',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Cliente',
                        'action' => 'list'
                    )
                )
            ),
            'perfil' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/perfil',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Perfil',
                        'action' => 'list'
                    )
                )
            ),
            'servicos' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/servicos',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Servicos',
                        'action' => 'list'
                    )
                )
            ),
            'prioridade' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/prioridade',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Prioridade',
                        'action' => 'list'
                    )
                )
            ),
            'solicitacao' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/solicitacao',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Solicitacao',
                        'action' => 'list'
                    )
                )
            ),
            'acompanhamento' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/acompanhamento',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Acompanhamento',
                        'action' => 'list'
                    )
                )
            ),
            'status' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/status',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Status',
                        'action' => 'list'
                    )
                )
            ),
            'direcionamento' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/direcionamento',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Direcionamento',
                        'action' => 'list'
                    )
                )
            ),
            'logs' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin/logs',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Logs',
                        'action' => 'list'
                    )
                )
            ),
            'basedeconhecimento' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/basedeconhecimento/list',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Basedeconhecimento',
                        'action' => 'list'
                    )
                )
            ),
            'teste' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/teste/list',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller' => 'Teste',
                        'action' => 'list'
                    )
                )
            )
        )
        
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\Adapter'
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'Validarcpf' => 'Admin\Controller\Plugin\Validarcpf',
            'RemoteValidate' => 'Admin\Controller\Plugin\RemoteValidate',
            'EnviarEmail' => 'Admin\Controller\Plugin\EnviarEmail',
            'GerarLog' => 'Admin\Controller\Plugin\GerarLog'
        )
        
    ),
    
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Departamento' => 'Admin\Controller\DepartamentoController',
            'Admin\Controller\Cliente' => 'Admin\Controller\ClienteController',
            'Admin\Controller\Perfil' => 'Admin\Controller\PerfilController',
            'Admin\Controller\Servicos' => 'Admin\Controller\ServicosController',
            'Admin\Controller\Prioridade' => 'Admin\Controller\PrioridadeController',
            'Admin\Controller\Solicitacao' => 'Admin\Controller\SolicitacaoController',
            'Admin\Controller\Acompanhamento' => 'Admin\Controller\AcompanhamentoController',
            'Admin\Controller\Status' => 'Admin\Controller\StatusController',
            'Admin\Controller\Direcionamento' => 'Admin\Controller\DirecionamentoController',
            'Admin\Controller\Logs' => 'Admin\Controller\LogsController',
            'Admin\Controller\Basedeconhecimento' => 'Admin\Controller\BasedeconhecimentoController'
        )
    ),
    'view_manager' => array(
        
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
