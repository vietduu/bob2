<?php
namespace Bob\Model\DataObject;
use Bob\Model\InterfaceHelper\ModelInterface;

class UrlReference implements ModelInterface {
	public $url_id;
	public $url;
	public $url_mapper_fk;

	public function __construct($url_id, $url, $url_mapper_fk) {
		$this->url_id = (string) $url_id;
		$this->url = (string) $url;
		$this->url_mapper_fk = (string) $url_mapper_fk;
	}

	public function exchangeArray($data)
	{
		$this->url_id = (!empty($data['url_id'])) ? $data['url_id'] : null;
		$this->url = (!empty($data['url'])) ? $data['url'] : null;
		$this->url_mapper_fk = (!empty($data['url_mapper_fk'])) ? $data['url_mapper_fk'] : null;	
	}
}