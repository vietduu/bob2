<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\CmsItemType;

class CmsItemTypeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->id_cms_item_type, "int");
		settype($entity->key, "string");
		settype($entity->description, "string");
		settype($entity->label, "string");
		settype($entity->xtype, "string");
		settype($entity->parent_id, "int");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'CmsItemType');
		return array(
			'id_cms_item_type' => $entity->id_cms_item_type,
			'key' => $entity->key,
			'description' => $entity->description,
			'label' => $entity->label,
			'xtype' => $entity->xtype,
			'parent_id' => $entity->parent_id,
		);
	}

	public function getModelObject()
	{
		return CmsItemType::class;
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('id_cms_item_type' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the cms item type ID $id');
		}	

		return (array)$row;
	}
}