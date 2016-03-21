<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\CmsFolderType;

class CmsFolderTypeMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->id_cms_folder_type, "int");
		settype($entity->key, "string");
		settype($entity->description, "string");
		settype($entity->label, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'CmsFolderType');
		return array(
			'id_cms_folder_type' => $entity->id_cms_folder_type + 1,
			'key' => $entity->key,
			'description' => $entity->description,
			'label' => $entity->label,
		);
	}

	public function getModelObject()
	{
		return CmsFolderType::class;
	}
}