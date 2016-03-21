<?php
namespace Bob\Model\DataMapper;

use Bob\Model\DataObject\ProductType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class ProductTypeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->id, "int");
		settype($entity->name, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'ProductType');
		return array(
			'id' => $entity->id,
			'name' => $entity->name,
			);
	}

	public function getModelObject()
	{
		return ProductType::class;
	}
}