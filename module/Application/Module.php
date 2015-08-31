<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Model\Customer;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\Model\CustomerTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Application\Model\Register;
use Application\Model\RegisterTable;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
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
                'Application\Model\CustomerTable' =>  function($sm) 
                {
                     $tableGateway = $sm->get('CustomerTableGateway');
                     $table = new CustomerTable($tableGateway);
                     return $table;
                 },
                'Application\Model\RegisterTable' =>  function($sm) 
                {
                     $tableGateway = $sm->get('RegisterTableGateway');
                     $table = new RegisterTable($tableGateway);
                     return $table;
                 },
                 'CustomerTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Customer());
                     return new TableGateway('customer', $dbAdapter, null, $resultSetPrototype);
                 },
                'RegisterTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Register());
                     return new TableGateway('registration', $dbAdapter, null, $resultSetPrototype);
                 },
                         
             ),
         );
     }

}
