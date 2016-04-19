<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\CmsItem;
use Zend\Db\Sql\Sql;

class CmsItemMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->id_cms_item, "int");
		settype($entity->fk_cms_folder, "int");
		settype($entity->fk_cms_item_type, "int");
	//	settype($entity->content, "string");
		settype($entity->created_at, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'CmsItem');
		return array(
			'id_cms_item' => $entity->id_cms_item,
			'fk_cms_folder' => $entity->fk_cms_folder,
			'fk_cms_item_type' => $entity->fk_cms_item_type + 1,
			'content' => $entity->content,
		);
	}

	public function getModelObject()
	{
		return CmsItem::class;
	}

	public function getAllCmsItemsOfFolder($id)
	{
		$sql = new Sql($this->getAdapter());
		$select = $sql->select();
		$select	->from('cms_item')
				->where(array('fk_cms_folder'=>$id));
		$statement = $sql->prepareStatementForSqlObject($select);
		$result = $statement->execute();
		return $result;
	}

	public function getFullCmsItemOfFolder($id)
	{
		$sql = "SELECT * FROM cms_item ci JOIN cms_item_type cit "
				. "ON (ci.fk_cms_item_type = cit.id_cms_item_type) "				
				. "WHERE ci.fk_cms_folder = ?";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('id_cms_item' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the cms item ID $id');
		}	

		return (array)$row;
	}

	public function deleteById($id)
	{
		$this->getTableGateway()->delete(array('id_cms_item' => $id));
	}
}