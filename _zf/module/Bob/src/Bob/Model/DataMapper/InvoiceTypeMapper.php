<?php
namespace Bob\Model\DataMapper;

use Bob\Model\DataObject\InvoiceType;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class InvoiceTypeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->invoice_type_id, "int");
		settype($entity->invoice_type_name, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'InvoiceType');
		return array(
			'invoice_type_id' => $entity->invoice_type_id,
			'invoice_type_name' => $entity->invoice_type_name,
			);
	}

	public function getModelObject()
	{
		return InvoiceType::class;
	}
}