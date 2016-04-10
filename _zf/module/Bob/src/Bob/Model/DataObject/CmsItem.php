<?php
namespace Bob\Model\DataObject;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CmsItem implements \Bob\Model\InterfaceHelper\ModelInterface, InputFilterAwareInterface
{
	public $id_cms_item;
	public $fk_cms_folder;
	public $fk_cms_item_type;
	public $content;
	public $created_at;
	protected $inputFilter;

/*	public function __construct($fk_cms_folder, $fk_cms_item_type, $content){
		$this->fk_cms_folder = $fk_cms_folder;
		$this->fk_cms_item_type = $fk_cms_item_type;
		$this->content = $content;
	}*/

	public function exchangeArray($data)
	{
		$this->id_cms_item = (!empty($data['id_cms_item'])) ? $data['id_cms_item'] : null;
		$this->fk_cms_folder = (!empty($data['fk_cms_folder'])) ? $data['fk_cms_folder'] : null;
		$this->fk_cms_item_type = (!empty($data['fk_cms_item_type'])) ? $data['fk_cms_item_type'] : null;
		$this->content = (!empty($data['content'])) ? $data['content'] : null;
		$this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
	}

	public function setInputFilter(InputFilterInterface $inputFilter){
		throw new \Exception("Not used");
	}

	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
            $factory = new InputFactory();

			$inputFilter->add($factory->createInput(array(
				'name'     => 'id_cms_item',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
			)));

			$inputFilter->add($factory->createInput(array(
                 'name'     => 'content',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
            )));

            $this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}