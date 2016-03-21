<?php
namespace Bob\Model\DataObject;

class InvoiceType implements \Bob\Model\InterfaceHelper\ModelInterface
{
	public $invoice_type_id;
	public $invoice_type_name;

	public function exchangeArray($data)
	{
		$this->invoice_type_id = (!empty($data['invoice_type_id'])) ? $data['invoice_type_id'] : null;
		$this->invoice_type_name = (!empty($data['invoice_type_name'])) ? $data['invoice_type_name'] : null;
	}
}