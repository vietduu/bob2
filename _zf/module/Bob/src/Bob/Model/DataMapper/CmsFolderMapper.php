<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\CmsFolder;

class CmsFolderMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->id_cms_folder, "int");
		settype($entity->fk_cms_folder_type, "int");
		settype($entity->key, "string");
		settype($entity->description, "string");
		settype($entity->is_active, "bool");
		settype($entity->revision, "string");
		settype($entity->created_at, "string");
		settype($entity->is_published, "bool");
	}

	public function getModelData($entity)
	{
		$this->settype($entity);
		return array(
			'id_cms_folder' => $entity->id_cms_folder,
			'fk_cms_folder_type' => $entity->fk_cms_folder_type + 1,
			'key' => $entity->key,
			'description' => $entity->description,
			'is_active' => $entity->is_active,
			'revision' => $entity->revision,
			'is_published' => $entity->is_published,
			);
	}

	public function getModelObject()
	{
		return CmsFolder::class;
	}

	public function getFullCmsFolder(){	
		$sql = "SELECT folder.*, type.label FROM cms_folder folder LEFT JOIN cms_folder_type type "
				. "ON (folder.fk_cms_folder_type = type.id_cms_folder_type) "
				. "ORDER BY folder.id_cms_folder";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute();
		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('id_cms_folder' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the cms folder ID $id');
		}	

		return (array)$row;
	}

	public function getByKey($key)
	{
		$set = $this->getTableGateway()->select(array('key' => $key));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the cms folder $key');
		}	

		return (array)$row;
	}


	public function deleteById($id)
	{
		$this->getTableGateway()->delete(array('id_cms_folder' => $id));
	}
}