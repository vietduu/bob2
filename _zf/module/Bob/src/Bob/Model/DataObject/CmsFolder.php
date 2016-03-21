<?php
namespace Bob\Model\DataObject;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CmsFolder implements \Bob\Model\InterfaceHelper\ModelInterface, InputFilterAwareInterface
{
	public $id_cms_folder;
	public $fk_cms_folder_type;
	public $key;
	public $description;
	public $is_active;
	public $revision;
	public $created_at;
	public $is_published;
	protected $inputFilter;

	public function exchangeArray($data)
	{
		$this->id_cms_folder = (!empty($data['id_cms_folder'])) ? $data['id_cms_folder'] : null;
		$this->fk_cms_folder_type = (!empty($data['fk_cms_folder_type'])) ? $data['fk_cms_folder_type'] : null;
		$this->key = (!empty($data['key'])) ? $data['key'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
		$this->is_active = (!empty($data['is_active'])) ? $data['is_active'] : null;
		$this->revision = (!empty($data['revision'])) ? $data['revision'] : null;
		$this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
		$this->is_published = (!empty($data['is_published'])) ? $data['is_published'] : null;
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
				'name'     => 'id_cms_folder',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
			)));

			$inputFilter->add($factory->createInput(array(
                 'name'     => 'key',
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
                 'name'     => 'description',
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

       /*     $inputFilter->add($factory->createInput(array(
                'name'     => 'fk_cms_folder_type',
                'validators' => array(
                    array(
                        'name'    => 'InArray',
                        'options' => array(
                            'haystack' => array(1,3),
                            'messages' => array(
                                'notInArray' => 'Please select folder type!' 
                            ),
                        ),
                    ),
            	)
            )));*/

            $this->inputFilter = $inputFilter;
		}

		return $this->inputFilter;
	}
}