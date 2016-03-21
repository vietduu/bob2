<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\UrlReference;

class UrlReferenceMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	private $urls = [
		'home' => [
			'url' => 'home',
			'title' => 'Home',
			'content' => 'This is the content!',
		],
		'contact' => [
			'url' => 'contact',
			'title' => 'Contact',
			'content' => 'This is the contact page!',
		],
	];

	public function getModelData($entity)
	{
		$this->settype($entity, 'UrlReference');
		return array(
			'url_id' => $entity->url_id,
			'url' => $entity->url,
			'url_mapper_fk' => $entity->url_mapper_fk,
			);
	}

	public function getModelObject()
	{
		return UrlReference::class;
	}



/*	public function getImagesFromProductId($id)
	{
		$sql = "SELECT images.* FROM images INNER JOIN general_product gp "
				. "ON (gp.general_id = images.general_product_fk) "
				. "WHERE gp.general_id = ? "
				. "ORDER BY images.is_default DESC";
		$statement = $this->getAdapter()->query($sql);	
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}*/

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('url_id' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the url ID$id');
		}	

		return (array)$row;
	}

	public function findByUrl($url)
	{
		if (!isset($this->urls[$url])){
			return null;
		}

		$url = $this->urls[$url];

		return new UrlReference($url['url'], $url['title'], $url['content']);
	}
}