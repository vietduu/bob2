<?php
namespace Bob\Model\DataObject;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class AclUser implements \Bob\Model\InterfaceHelper\ModelInterface, InputFilterAwareInterface
{
    public $user_id;
    public $user_name;
    public $password;
    protected $inputFilter;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->user_name = (!empty($data['user_name'])) ? $data['user_name'] : null;
        $this->password = (!empty($data['password'])) ? $data['password'] : null;
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
                 'name'     => 'username',
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
                 'name'     => 'password',
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

            $this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}