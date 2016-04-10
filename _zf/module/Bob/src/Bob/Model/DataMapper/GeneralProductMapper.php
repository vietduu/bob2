<?php
namespace Bob\Model\DataMapper;
use Bob\Model\DataObject\GeneralProduct;

class GeneralProductMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->general_id, "int");
		settype($entity->general_name, "string");
		settype($entity->sku, "string");
		settype($entity->description_fk, "int");
		settype($entity->product_type_fk, "int");
		settype($entity->invoice_flag, "bool");
		settype($entity->invoice_type_fk, "int");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'GeneralProduct');
		return array(
			'general_id' => $entity->general_product_id,
			'general_name' => $entity->general_name,
			'sku' => $entity->sku,
			'description_fk' => $entity->description_fk,
			'product_type_fk' => $entity->product_type_fk,
			'invoice_flag' => $entity->invoice_flag,
			'invoice_type_fk' => $entity->invoice_type_fk,
			);
	}

	public function getModelObject()
	{
		return GeneralProduct::class;
	}

	public function getProductsByProductTypeId($id)
	{
		$sql = "SELECT * FROM general_product gp LEFT JOIN product_type pt "
				. "ON (gp.product_type_fk = pt.id) "
				. "WHERE pt.id = ?";
		$statement = $this->getAdapter()->query($sql);		
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}

	public function getFullInformationByTypeId($id)
	{
		$sql = "SELECT * FROM general_product gp LEFT JOIN product_type pt "
				. "ON (gp.product_type_fk = pt.id) "
				. "LEFT JOIN images ON (gp.general_id = images.general_product_fk) "
				. "LEFT JOIN description ON (description.description_id = gp.description_fk) "
				. "WHERE pt.id = ?";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}

	public function getProductInformationByInvoiceTypeId($id=null)
	{
		$sql = "SELECT * FROM general_product gp LEFT JOIN invoice_type it "
				. "ON (gp.invoice_type_fk = it.invoice_type_id) "
				. "LEFT JOIN images ON (gp.general_id = images.general_product_fk) "
				. "LEFT JOIN description ON (description.description_id = gp.description_fk) "
	//			. "WHERE gp.invoice_flag = 1 AND it.invoice_type_id = " . $id;
				. "WHERE gp.invoice_flag = 1 AND images.is_default = 1";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute();

		return $result->getResource()->fetchAll();
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array('general_id' => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find the product type ID$id');
		}	

		return (array)$row;
	}

	public function getFullInformationById($id)
	{
		$sql = "SELECT * FROM general_product gp "
				. "LEFT JOIN product_type pt ON (gp.product_type_fk = pt.id) "
				. "LEFT JOIN images ON (gp.general_id = images.general_product_fk) "
				. "LEFT JOIN invoice_type it ON (it.invoice_type_id = gp.invoice_type_fk) "
				. "LEFT JOIN description ON (description.description_id = gp.description_fk) "
				. "WHERE gp.general_id = ?";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute(array($id));
		return $result->getResource()->fetchAll();
	}

	public function getFullInformationByUrl($url)
	{
		$sql = "SELECT * FROM general_product gp "
				. "LEFT JOIN product_type pt ON (gp.product_type_fk = pt.id) "
				. "LEFT JOIN invoice_type it ON (it.invoice_type_id = gp.invoice_type_fk) "
				. "WHERE pt.product_type_url = ? || it.invoice_type_url = ?";
		$statement = $this->getAdapter()->query($sql);
		$result = $statement->execute(array($url, $url));
		return $result->getResource()->fetchAll();
	}
}