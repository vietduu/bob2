<?php
namespace Bob\Model\DataMapper;

use Bob\Model\DataObject\AclUser;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class AclUserMapper extends \Bob\Model\InterfaceHelper\AbstractMapper
{
	public function __construct($tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function settype(&$entity){
		settype($entity->user_id, "int");
		settype($entity->user_name, "string");
		settype($entity->password, "string");
	}

	public function getModelData($entity)
	{
		$this->settype($entity, 'AclUser');
		return array(
			'user_id' => $entity->user_id,
			'user_name' => $entity->user_name,
			'password' => $entity->password,
			);
	}

	public function getModelObject()
	{
		return AclUser::class;
	}

	public function getByUsername($name)
	{
		$set = $this->getTableGateway()->select(array('user_name' => $name));
		$row = $set->current();
		if (!$row){
			return null;
		}	

		return (array)$row;
	}

	public function authenticateUser($name, $pwd){
		$aclUser = $this->getByUsername($name);
		if ($aclUser == null){
			return -1;
		}

		if ($aclUser['password'] == $pwd){
			return 1;
		}

		return 0;
	}

}