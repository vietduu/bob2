<?php
namespace Bob\Model\InterfaceHelper;

abstract class AbstractMapper
{
	protected $tableGateway;

	/**
	 * GeneralProductMapper constructor.
	 * @param $tableGateway
	 */
	protected function __construct($tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getTableGateway()
	{
		return $this->tableGateway;
	}

	public function getAdapter(){
		return $this->tableGateway->getAdapter();
	}

	public function fetchAll()
	{
		$resultSet = $this->getTableGateway()->select();
		return $resultSet;
	}

	public function getById($id)
	{
		$id = (int) $id;
		$set = $this->getTableGateway()->select(array(0 => $id));
		$row = $set->current();
		if (!$row){
			throw new \Exception('Could not find ID$id');
		}	

		return (array)$row;
	}

	public function deleteById($id)
	{
		$this->getTableGateway()->delete(array(0 => (int) $id));
	}


	public abstract function getModelData($entity);

	public abstract function getModelObject();


	public function save($entity)
	{
		$data = $this->getModelData($entity);

		settype(array_values($data)[0], "int");
		$id = array_values($data)[0];

		if (0 == $id)
		{
			$this->getTableGateway()->insert($data);
		} else {
			if ($this->getById($id)){
				$this->getTableGateway()->update($data, array(array_keys($data)[0] => $id));
		} else {
			throw new \Exception('ID does not exist');
			}
		}
	}
}