<?php
namespace Bob\Model\DataObject;

class ProductType implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $id;
	public $name;

	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id'])) ? $data['id'] : null;
		$this->name = (!empty($data['name'])) ? $data['name'] : null;
	}
}