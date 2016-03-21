<?php
namespace Bob\Model\DataObject;

class CmsItemType implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $id_cms_item_type;
	public $key;
	public $label;
	public $description;
	public $xtype;
	public $parent_id;

	public function exchangeArray($data)
	{
		$this->id_cms_item_type = (!empty($data['id_cms_item_type'])) ? $data['id_cms_item_type'] : null;
		$this->key = (!empty($data['key'])) ? $data['key'] : null;
		$this->label = (!empty($data['label'])) ? $data['label'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
		$this->xtype = (!empty($data['xtype'])) ? $data['xtype'] : null;
		$this->parent_id = (!empty($data['parent_id'])) ? $data['parent_id'] : null;
	}
}