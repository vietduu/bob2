<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Bob;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;

class Module implements AutoloaderProviderInterface
{
    public function init(ModuleManager $mm)
    {
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__,
        'dispatch', function($e) {
            $config = $e->getApplication()->getServiceManager()->get('config');
            $routeMatch = $e->getRouteMatch();
            $namespace = array_shift(explode('\\', $routeMatch->getParam('controller')));
            $controller = $e->getTarget();
            $controllerName = array_pop(explode('\\', $routeMatch->getParam('controller')));
            $actionName = strtolower($routeMatch->getParam('action'));

            // Use the layout assigned to the action
            if(isset($config['layouts'][$namespace]['controllers'][$controllerName]['actions'][$actionName]))
            {
                $controller->layout($config['layouts'][$namespace]['controllers'][$controllerName]['actions'][$actionName]);
            }
            // Use the controller default layout
            elseif(isset($config['layouts'][$namespace]['controllers'][$controllerName]['default']))
            {
                $controller->layout($config['layouts'][$namespace]['controllers'][$controllerName]['default']);
            }
            // Use the module default layout
            elseif(isset($config['layouts'][$namespace]['default']))
            {
                $controller->layout($config['layouts'][$namespace]['default']);
            }

        }, 10);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        $config = include __DIR__ . '/config/module.config.php';
        $config['router'] = array(
            'routes' => array(
            'bob' => array(
                'type'    => 'Literal',
                'options' => array(
                   'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bob\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
            'pet' => array(
                'type'    => 'Literal',
                'options' => array(
                   'route'    => '/pet/product/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bob\Controller',
                        'controller'    => 'Index',
                        'action'        => 'pet',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'product' => array(
                        'type' => 'Zend\Mvc\Router\Http\Regex',
                        'options' => array(
                            'regex' => '(?<id>[a-zA-Z0-9_-]+)\.html',
                            'defaults' => array(
                                '__NAMESPACE__' => 'Bob\Controller',
                                'controller' => 'Index',
                                'action' => 'product',
                            ),
                            'spec' => '%id%.html',
                        ),
                    ),
                ),
            ),
            'cms' => array(
                'type'    => 'Literal',
                'options' => array(
                   'route'    => '/cms',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Bob\Controller',
                        'controller'    => 'Cms',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'action' => 'add',
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/edit[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'edit',
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/delete[/:id]',
                            'constraints' => array(
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'action' => 'delete',
                            ),
                        ),
                    ),
                ),
            ),
        ));
        return $config;
    }

    public function onBootstrap(MvcEvent $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
