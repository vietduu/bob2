<?php
namespace Bob\Model\DataObject;

class GeneralProduct implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $general_product_id;
	public $sku;
	public $general_name;
	public $description_fk;
	public $invoice_flag;
	public $invoice_type_fk;
	public $product_type_fk;

	public function exchangeArray($data)
	{
		$this->general_product_id = (!empty($data['general_id'])) ? $data['general_id'] : null;
		$this->sku = (!empty($data['sku'])) ? $data['sku'] : null;
		$this->general_name = (!empty($data['general_name'])) ? $data['general_name'] : null;
		$this->description_fk = (!empty($data['description_fk'])) ? $data['description_fk'] : null;
		$this->invoice_flag = (!empty($data['invoice_flag'])) ? $data['invoice_flag'] : null;
		$this->invoice_type_fk = (!empty($data['invoice_type_fk'])) ? $data['invoice_type_fk'] : null;
		$this->product_type_fk = (!empty($data['product_type_fk'])) ? $data['product_type_fk'] : null;
	}
}