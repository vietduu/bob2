<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\Attribute;

class AttributeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->attribute_id, "int");
		settype($entity->attribute_name, "string");
		settype($entity->fk_attribute_type_id, "int");
		settype($entity->fk_product_id, "int");
		settype($entity->attribute_long_name, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity);
		return array(
			'attribute_id' => $entity->attribute_id,
			'attribute_name' => $entity->attribute_name,
			'fk_attribute_type_id' => $entity->fk_attribute_type_id,
			'fk_product_id' => $entity->fk_product_id,
			'attribute_long_name' => $entity->attribute_long_name,
			);
	}

	public function getModelObject()
	{
		return CmsFolder::class;
	}

	public function getAll(){	
		$sql = "SELECT * FROM attribute";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute();
		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('attribute_id' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the attribute $id');
		}	

		return (array)$row;
	}

	public function getProductAttribute($id){	
		$sql = "SELECT * FROM attribute LEFT JOIN attribute_type "
				. "ON attribute.fk_attribute_type_id = attribute_type.attribute_type_id "
				. "WHERE fk_product_id = ? "
				. "ORDER BY fk_attribute_type_id";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}
}