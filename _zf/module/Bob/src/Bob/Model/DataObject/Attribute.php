<?php
namespace Bob\Model\DataObject;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Attribute implements \Bob\Model\InterfaceHelper\ModelInterface, InputFilterAwareInterface
{
	public $attribute_id;
	public $attribute_name;
	public $fk_attribute_type_id;
    public $fk_product_id;
    public $attribute_long_name;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->attribute_id = (!empty($data['attribute_id'])) ? $data['attribute_id'] : null;
		$this->attribute_name = (!empty($data['attribute_name'])) ? $data['attribute_name'] : null;
		$this->fk_attribute_type_id = (!empty($data['fk_attribute_type_id'])) ? $data['fk_attribute_type_id'] : null;
        $this->fk_product_id = (!empty($data['fk_product_id'])) ? $data['fk_product_id'] : null;
        $this->attribute_long_name = (!empty($data['attribute_long_name'])) ? $data['attribute_long_name'] : null;
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
				'name'     => 'attribute_type_id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
			)));

			$inputFilter->add($factory->createInput(array(
                 'name'     => 'attribute_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 255,
                         ),
                     ),
                 ),
            )));

            $inputFilter->add($factory->createInput(array(
                 'name'     => 'attribute_long_name',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                         ),
                     ),
                 ),
            )));

            $this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}