<?php
namespace Bob\Helper;

class ServiceConfigHelper
{
	public static function getAdapter($owner){
		$serviceLocator = $owner->getServiceLocator();
		$adapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
		return $adapter;
	}

	public static function getServiceConfig($owner, $modelName, $table, $mapper)
	{
		$adapter = static::getAdapter($owner);
		$resultSet = new \Zend\Db\ResultSet\ResultSet();
		$resultSet->setArrayObjectPrototype(new $modelName);

		$tableGateway = new \Zend\Db\TableGateway\TableGateway($table, $adapter, null, $resultSet);

		$returning_mapper = new $mapper($tableGateway);

		return $returning_mapper;
	}
}