<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\Images;

class ImagesMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->image_id, "int");
		settype($entity->source, "string");
		settype($entity->alt_tag, "string");
		settype($entity->general_product_fk, "int");
		settype($entity->title, "string");
		settype($entity->is_default, "bool");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'Images');
		return array(
			'image_id' => $entity->image_id,
			'source' => $entity->source,
			'alt_tag' => $entity->alt_tag,
			'general_product_fk' => $entity->general_product_fk,
			'title' => $entity->title,
			'is_default' => $entity->is_default,
			);
	}

	public function getModelObject()
	{
		return Images::class;
	}

	public function getImagesFromProductId($id)
	{
		$sql = "SELECT images.* FROM images INNER JOIN general_product gp "
				. "ON (gp.general_id = images.general_product_fk) "
				. "WHERE gp.general_id = ? "
				. "ORDER BY images.is_default DESC";
		$statement = $this->getAdapter()->query($sql);	
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('image_id' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the product type ID$id');
		}	

		return (array)$row;
	}
}