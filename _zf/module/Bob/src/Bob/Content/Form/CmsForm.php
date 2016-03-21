<?php
namespace Bob\Content\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Bob\Model\DataObject\CmsFolder;
use Bob\Model\DataMapper\CmsFolderTypeMapper;
use Zend\Db\Adapter\AdapterInterface;
use Bob\Helper\ConcreteServiceConfig;
use Zend\Db\Adapter\Adapter;

class CmsForm extends Form 
{
	protected $adapter;

	public function __construct(AdapterInterface $adapter) {
		parent::__construct('cms');
		$this->adapter = $adapter;

		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'id_cms_folder',
			'attributes' => array(
				'type' => 'hidden',
			),
		));


		$this->add(array(
			'name' => 'fk_cms_folder_type',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'CMS folder type:',
			//	'empty_option' => 'Please select',
				'value_options' => $this->getAllCmsFolderTypes(),
			),
			'attributes' => array(
				'value' => '1'
			)
		));



		$this->add(array(
			'name' => 'key',
			'type' => 'Text',
			'options' => array(
				'label' => 'Key:',
			),
		));

		$this->add(array(
			'name' => 'description',
			'type' => 'Text',
			'options' => array(
				'label' => 'Description:',
			),
		));

		$this->add(array(
			'name' => 'is_active',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'Is active',
				'checked_value' => '1',
				'unchecked_value' => '0'
				),
			'attributes' => array(
         		'value' => '1'
    		)
		));

		$this->add(array(
			'name' => 'is_published',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'Is published',
				'checked_value' => '1',
				'unchecked_value' => '0'
				),
			'attributes' => array(
         		'value' => '1'
    		)
		));

		$this->add(array(
            'type' => 'Csrf',
            'name' => 'csrf',
            'options' => array(
            'csrf_options' => array(
                'timeout' => 600
            ))
        ));


		$this->add(array(
             'name' => 'submit',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Save',
                 'id' => 'submit_btn',
             ),
        ));
	}

	public function populateValues($data)
    {   
        foreach($data as $key=>$row)
        {
           if (is_array(@json_decode($row))){
                $data[$key] =   new \ArrayObject(\Zend\Json\Json::decode($row), \ArrayObject::ARRAY_AS_PROPS);
           }
        } 
         
        parent::populateValues($data);
    }

    public function getAllCmsFolderTypes(){
    	$adapter = $this->adapter;
    	$sql = "SELECT * FROM cms_folder_type";
    	$statement = $adapter->query($sql);
        $result    = $statement->execute();
        $types 	   = $result->getResource()->fetchAll();

        $selectData = array();
        foreach ($types as $type) {
            $selectData[] = $type[2];
        }

        return $selectData;
    }
}