<?php
namespace Bob\Model\DataObject;

class Images implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $image_id;
	public $source;
	public $alt_tag;
	public $general_product_fk;
	public $title;
	public $is_default;

	public function exchangeArray($data)
	{
		$this->image_id = (!empty($data['image_id'])) ? $data['image_id'] : null;
		$this->source = (!empty($data['source'])) ? $data['source'] : null;
		$this->alt_tag = (!empty($data['alt_tag'])) ? $data['alt_tag'] : null;
		$this->general_product_fk = (!empty($data['general_product_fk'])) ? $data['general_product_fk'] : null;
		$this->title = (!empty($data['title'])) ? $data['title'] : null;
		$this->is_default = (!empty($data['is_default'])) ? $data['is_default'] : null;
	}
}