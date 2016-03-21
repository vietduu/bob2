<?php
namespace Bob\Model\DataObject;

class CmsFolderType implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $id_cms_folder_type;
	public $key;
	public $label;
	public $description;

	public function exchangeArray($data)
	{
		$this->id_cms_folder_type = (!empty($data['id_cms_folder_type'])) ? $data['id_cms_folder_type'] : null;
		$this->key = (!empty($data['key'])) ? $data['key'] : null;
		$this->label = (!empty($data['label'])) ? $data['label'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
	}
}