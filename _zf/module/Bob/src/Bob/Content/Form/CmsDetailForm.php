<?php
namespace Bob\Content\Form;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\Db\Adapter\AdapterInterface;

class CmsDetailForm extends Form 
{
	protected $adapter;

	public function __construct(AdapterInterface $adapter) {
		parent::__construct('cms-detail-page');
		$this->adapter = $adapter;

		$this->setAttribute('method','post');

		$this->add(array(
			'name' => 'fk_cms_item_type',
			'type' => 'Zend\Form\Element\Select',
			'options' => array(
				'label' => 'CMS item type:',
				'empty_option' => 'Please select...',
				'value_options' => $this->getAllCmsItemTypes(),
			)
		));

		$this->add(array(
             'name' => 'submit',
             'attributes' => array(
             	 'type' => 'submit',
                 'value' => 'Create',
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

    public function getAllCmsItemTypes(){
    	$adapter = $this->adapter;
    	$sql = "SELECT * FROM cms_item_type";
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