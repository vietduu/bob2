<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\AttributeType;

class AttributeTypeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->attribute_type_id, "int");
		settype($entity->attribute_type_name, "string");
		settype($entity->attribute_long_name, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity);
		return array(
			'attribute_type_id' => $entity->attribute_type_id,
			'attribute_type_name' => $entity->attribute_type_name,
			'attribute_long_name' => $entity->attribute_long_name,
			);
	}

	public function getModelObject()
	{
		return CmsFolder::class;
	}

	public function getAll(){	
		$sql = "SELECT * FROM attribute_type";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute();
		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('attribute_type_id' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the attribute type $id');
		}	

		return (array)$row;
	}
}